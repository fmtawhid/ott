<?php

namespace Modules\Subscriptions\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Subscriptions\Http\Requests\SubscriptionRequest;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Models\SubscriptionTransactions;
use Modules\Subscriptions\Trait\SubscriptionTrait;
use Modules\Subscriptions\Transformers\SubscriptionResource;
use Modules\Subscriptions\Transformers\PlanlimitationMappingResource;
use Modules\Tax\Models\Tax;
use Modules\Coupon\Models\Coupon;
use App\Mail\SubscriptionDetail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    use SubscriptionTrait;

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function saveSubscriptionDetails(SubscriptionRequest $request)
    {
        $user_id = $request->user_id ? $request->user_id : auth()->id();

        $user = User::where('id', $user_id)->first();

        $timezone = date_default_timezone_set($this->getTimeZone());

        $get_existing_plan = $this->get_user_active_plan($user_id);

        $active_plan_left_days = 0;

        // Set Default Status

        $status = config('constant.SUBSCRIPTION_STATUS.PENDING');
        $start_date = date('Y-m-d H:i:s');

        if ($get_existing_plan) {
                        // $active_plan_left_days = $this->check_days_left_plan($get_existing_plan);
            if ($request->identifier != $get_existing_plan->identifier) {
                $get_existing_plan->update([
                    'status' => config('constant.SUBSCRIPTION_STATUS.INACTIVE'),
                ]);
                $get_existing_plan->save();
            }
        }

        $plan = Plan::where('id', $request->plan_id)->with('planLimitation')->first();
        $limitation_data = PlanlimitationMappingResource::collection($plan->planLimitation);

        $taxes = Tax::where('status', 1)->get();
        $baseAmount = $plan->price;

        // Apply discount percentage from the plan
        if ($plan['discount_percentage'] > 0) {
            $baseAmount = $plan->price - ($plan->price * $plan['discount_percentage'] / 100);
        }

        // Calculate taxes based on the baseAmount
        $totalTax = 0;

        foreach ($taxes as $tax) {

            if (strtolower($tax->type) == 'fixed') {

                $totalTax += $tax->value;
            } elseif (strtolower($tax->type) == 'percentage') {

                $totalTax += ($baseAmount * $tax->value) / 100;
            }
        }

        // Calculate the total amount before applying the coupon
        $totalAmount = $baseAmount + $totalTax;
        // Handle coupon discount
        $couponDiscount = 0;
        if ($request->has('coupon_id')) {
            $promotion = Coupon::where('id', $request->coupon_id)
                ->where('status', 1)
                ->whereHas('subscriptionPlans', function ($query) use ($request) {
                    $query->where('subscription_plan_id', $request->plan_id);
                })
                ->first();

            if ($promotion) {
                if ($promotion->discount_type == 'fixed') {
                    $couponDiscount = $promotion->discount;
                } elseif ($promotion->discount_type == 'percentage') {
                    $couponDiscount = ($totalAmount * $promotion->discount) / 100;
                }
                $totalAmount -= $couponDiscount;
                $totalAmount = max($totalAmount, 0); // Ensure the amount doesn't go negative
            }
        }

        $end_date = $this->get_plan_expiration_date($start_date, $plan['duration'], $plan['duration_value']);

        $subscribed_plan_data = [
            'plan_id' => $request->plan_id,
            'user_id' => $user_id,
            'device_id' => $request->device_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status,
            'amount' => $plan['price'],
            'discount_percentage' => $plan['discount_percentage'],
            'coupon_discount' => $couponDiscount, // Store the coupon discount
            'tax_amount' => $totalTax,
            'total_amount' => $totalAmount,
            'name' => $plan['name'],
            'identifier' => $plan['identifier'],
            'type' => $plan['duration'],
            'duration' => $plan['duration_value'],
            'level' => $plan['level'],
            'plan_type' => $limitation_data ? json_encode($limitation_data) : null,
            'coupon_id' => $request->coupon_id ?? null, // Store the coupon ID if provided
        ];

        $result = Subscription::create($subscribed_plan_data);

        if ($result) {
            $payment_data = [
                'subscriptions_id' => $result->id,
                'user_id' => $result->user_id,
                'amount' => $result->amount,
                'tax_data' => $taxes->isEmpty() ? null : json_encode($taxes),
                'payment_status' => $request->payment_status,
                'payment_type' => $request->payment_type,
                'transaction_id' => $request->transaction_id,
            ];
            $payment = SubscriptionTransactions::create($payment_data);

            if ($payment->payment_status == 'paid') {
                $result->status = config('constant.SUBSCRIPTION_STATUS.ACTIVE');
                $result->payment_id = $payment->id;
                $result->save();
                $user->is_subscribe = 1;
                $user->save();
                $message = __('messages.payment_completed');
            }
            $result->plan_type = json_decode($result->plan_type);
        }

        $response = new SubscriptionResource($result);
        $this->sendNotificationOnsubscription('new_subscription', $response);
        if (isSmtpConfigured()) {
            if ($user) {
                try {
                    Mail::to($user->email)->send(new SubscriptionDetail($response));
                    Log::info('Subscription detail email sent successfully to ' . $user->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
                }
            } else {
                Log::info('User object is not set. Email not sent.');
            }
        } else {
            Log::error('SMTP configuration is not set correctly. Email not sent.');
        }
          // $response = [

        //     'data' => $items,
        // ];

        return $this->sendResponse($response, __('messages.user_subscribe'));
    }

    public function getUserSubscriptionHistroy()
    {
        $user_id = auth()->id();

        return $this->sendResponse(SubscriptionResource::collection(Subscription::where('user_id', $user_id)->get()), __('messages.user_subscribe_history'));
    }

    public function cancelSubscription(Request $request)
    {
        $user_id = $request->user_id ? $request->user_id : auth()->id();
        $subscription_plan_id = $request->id;

        $user_subscription = Subscription::where('id', $subscription_plan_id)->where('user_id', $user_id)->first();

        $user = User::where('id', $user_id)->first();

        if ($user_subscription) {
            $user_subscription->status = config('constant.SUBSCRIPTION_STATUS.CANCLE');
            $user_subscription->save();
            $user->is_subscribe = 0;
            $user->save();
        }else{
            $message = __('messages.not_subscribe_cancel');

            return response()->json([
                'status' => false,
                'message' =>  $message, // Change the message to suit your needs
            ], 404);
        }
        $response = new SubscriptionResource($user_subscription);
        $this->sendNotificationOnsubscription('cancle_subscription', $response);
        if (isSmtpConfigured()) {
            if ($user) {
                try {
                    Mail::to($user->email)->send(new SubscriptionDetail($response));
                    Log::info('Subscription detail email sent successfully to ' . $user->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
                }
            } else {
                Log::info('User object is not set. Email not sent.');
            }
        } else {
            Log::error('SMTP configuration is not set correctly. Email not sent.');
        }
        $message = __('messages.subscribe_cancel');

        return $this->sendResponse($subscription_plan_id, $message);
    }
}
