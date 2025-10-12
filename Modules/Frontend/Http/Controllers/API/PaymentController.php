<?php

namespace Modules\Frontend\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\SubscriptionTransactions;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Trait\SubscriptionTrait;
use Modules\Subscriptions\Transformers\PlanlimitationMappingResource;
use Modules\Tax\Models\Tax;
use App\Models\User;
use Modules\Subscriptions\Transformers\SubscriptionResource;
use Modules\Subscriptions\Transformers\PlanResource;
use App\Mail\SubscriptionDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Coupon\Models\Coupon;

class PaymentController extends Controller
{
    use SubscriptionTrait;

    public function selectPlan(Request $request)
    {
        $planId = $request->input('plan_id') ?? Plan::first()?->id;

        $plans = PlanResource::collection(Plan::where('status',1)->get());

        $currentPlanId = Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->orderBy('id','desc')
            ->first()?->plan_id;

        $planId = $planId ?? $currentPlanId;
        $promotions = $this->getAvailablePromotions($planId);

        return response()->json([
            'success'     => true,
            'plans'       => $plans,
            'plan_id'     => $planId,
            'currentPlan' => $currentPlanId,
            'promotions'  => $promotions,
        ]);
    }

    protected function getAvailablePromotions($planId = null)
    {
        return Coupon::where('status', 1)
            ->where('start_date', '<=', now())
            ->where('expire_date', '>=', now())
            ->get();
    }

    public function getAvailablePromotionsRoute(Request $request)
    {
        $planId = $request->input('plan_id') ?? Plan::first()?->id;
        $promotions = $this->getAvailablePromotions($planId);

        return response()->json(['success' => true, 'promotions' => $promotions]);
    }

    public function processPayment(Request $request)
    {
        $user = User::find($request->user_id);
        $plan_id = $request->input('plan_id');
        $price   = $request->input('price');

        if (!$plan_id || !$price || $price <= 0) {
            return response()->json([
                'error' => 'Invalid plan or amount.'
            ], 400);
        }

        $tran_id = uniqid('TXN_');

        $post_data = [
            'store_id'        => env('SSLCZ_STORE_ID'),
            'store_passwd'    => env('SSLCZ_STORE_PASS'),
            'total_amount'    => $price,
            'currency'        => "BDT",
            'tran_id'         => $tran_id,
            'success_url'     => env('APP_URL') . '/api/payment/success',
            'fail_url'        => env('APP_URL') . '/api/payment/fail',
            'cancel_url'      => env('APP_URL') . '/api/payment/cancel',
            'cus_name'        => $user->name ?? ($user->first_name." ".$user->last_name),
            'cus_email'       => $user->email,
            'cus_add1'        => "Dhaka",
            'cus_city'        => "Dhaka",
            'cus_country'     => "Bangladesh",
            'shipping_method' => "NO",
            'product_name'    => "Subscription Plan",
            'product_category'=> "Service",
            'product_profile' => "general",
            'cus_phone'       => $user->mobile ?? '017xxxxxxxx',
            'value_a'         => $plan_id,
            'value_b'         => $user->id,
        ];

        $ssl_url = env('SSLCZ_IS_SANDBOX', true) 
                   ? "https://sandbox.sslcommerz.com/gwprocess/v4/api.php" 
                   : "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

        try {
            $response = Http::asForm()->post($ssl_url, $post_data);
            $sslcommerzResponse = $response->json();

            Log::info('SSLCommerz Response', $sslcommerzResponse);

            if (isset($sslcommerzResponse['GatewayPageURL']) && !empty($sslcommerzResponse['GatewayPageURL'])) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $sslcommerzResponse['GatewayPageURL']
                ]);
            } else {
                return response()->json([
                    'error' => 'Payment session creation failed.',
                    'response' => $sslcommerzResponse
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('SSLCommerz Request Failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Payment request failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function ipn(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $val_id  = $request->input('val_id');
        $plan_id = $request->input('value_a');
        $user_id = $request->input('value_b');

        if (!$tran_id || !$val_id) {
            return response()->json(['error' => 'Invalid IPN data'], 400);
        }

        $isSandbox = env('SSLCZ_IS_SANDBOX', true);
        $verifyUrl = $isSandbox
            ? "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php"
            : "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php";

        $verifyResponse = Http::get($verifyUrl, [
            'val_id'       => $val_id,
            'store_id'     => env('SSLCZ_STORE_ID'),
            'store_passwd' => env('SSLCZ_STORE_PASS'),
            'v'            => 1,
            'format'       => 'json'
        ]);

        $verifyData = $verifyResponse->json();

        if (isset($verifyData['status']) && $verifyData['status'] === 'VALID') {
            $amount  = $verifyData['amount'];
            $tran_id = $verifyData['tran_id'];

            return $this->handlePaymentSuccess($user_id, $plan_id, $amount, 'sslcommerz', $tran_id);
        }

        Log::error('IPN Verification Failed', ['tran_id' => $tran_id, 'response' => $verifyData]);
        return response()->json(['error' => 'Payment verification failed'], 400);
    }

    // public function paymentSuccess(Request $request)
    // {
    //     $plan_id = $request->value_a;
    //     $amount  = $request->amount;
    //     $tran_id = $request->tran_id;
    //     $user_id = $request->value_b;

    //     if ($plan_id && $amount && $tran_id) {
    //         return $this->handlePaymentSuccess($user_id, $plan_id, $amount, 'sslcommerz', $tran_id);
    //     }

    //     return response()->json(['error' => 'Payment verification failed!'], 400);
    // }
    public function paymentSuccess(Request $request)
    {
        // return response()->json(["data"=> $request->all()]);
        
        // Flutter থেকে আসা data
        $plan_id   = $request->plan_id; // plan id
        $user_id   = $request->user_id; // user id
        $amount    = $request->amount;  // paid amount
        $tran_id   = $request->tran_id; // transaction id

        // User খুঁজে বের করা
        $user = User::find($user_id);
        //  return response()->json(["data"=> $user]);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validation
        if (!$plan_id || !$amount || !$tran_id) {
            return response()->json(['error' => 'Invalid payment data'], 400);
        }

        // Payment success process
        return $this->handlePaymentSuccess($user_id, $plan_id, $amount, 'sslcommerz', $tran_id);
    }
   protected function handlePaymentSuccess($user_id, $plan_id, $amount, $payment_type, $transaction_id)
{
    $plan = Plan::findOrFail($plan_id);
    $limitation_data = PlanlimitationMappingResource::collection($plan->planLimitation);

    $user = User::find($user_id); 
    $start_date = now();
    $end_date = $this->get_plan_expiration_date($start_date, $plan->duration, $plan->duration_value);

    $taxes = Tax::active()->get();
    $totalTax = 0;

    foreach ($taxes as $tax) {
        if (strtolower($tax->type) == 'fixed') {
            $totalTax += $tax->value;
        } elseif (strtolower($tax->type) == 'percentage') {
            $totalTax += ($plan->price * $tax->value) / 100;
        }
    }

    // ✅ Step 1: পুরোনো active subscription inactive করা
    Subscription::where('user_id', $user->id)
        ->where('status', 'active')
        ->update(['status' => 'inactive']);

    // ✅ Step 2: নতুন subscription তৈরি
    $subscription = Subscription::create([
        'plan_id' => $plan_id,
        'user_id' => $user->id,
        'device_id' => 1,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => 'active',
        'amount' => $plan->price,
        'discount_percentage' => $plan->discount_percentage,
        'tax_amount' => $totalTax,
        'total_amount' => $amount,
        'name' => $plan->name,
        'identifier' => $plan->identifier,
        'type' => $plan->duration,
        'duration' => $plan->duration_value,
        'level' => $plan->level,
        'plan_type' => $limitation_data ? json_encode($limitation_data) : null,
        'payment_id' => $transaction_id,
    ]);

    SubscriptionTransactions::create([
        'user_id' => $user->id,
        'amount' => $amount,
        'payment_type' => $payment_type,
        'payment_status' => 'paid',
        'tax_data' => $taxes->isEmpty() ? null : json_encode($taxes),
        'transaction_id' => $transaction_id,
        'subscriptions_id' => $subscription->id,
    ]);

    $response = new SubscriptionResource($subscription);
    $this->sendNotificationOnsubscription('new_subscription', $response);

    if (isSmtpConfigured()) {
        try {
            Mail::to($user->email)->send(new SubscriptionDetail($response));
        } catch (\Exception $e) {
            Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
        }
    }

    $user->update(['is_subscribe' => 1]);

    return response()->json([
        'success' => true,
        'message' => 'Payment completed successfully!',
        'subscription' => $response
    ]);
}




    public function paymentFail()
    {
        return response()->json(['error' => 'Payment failed. Please try again.'], 400);
    }

    public function paymentCancel()
    {
        return response()->json(['error' => 'Payment cancelled by user.'], 400);
    }

    // protected function handlePaymentSuccess($user_id, $plan_id, $amount, $payment_type, $transaction_id)
    // {
    //     $plan = Plan::findOrFail($plan_id);
    //     $limitation_data = PlanlimitationMappingResource::collection($plan->planLimitation);

    //     $user = User::find($user_id);
    //     $start_date = now();
    //     $end_date = $this->get_plan_expiration_date($start_date, $plan->duration, $plan->duration_value);

    //     $taxes = Tax::active()->get();
    //     $totalTax = 0;

    //     foreach ($taxes as $tax) {
    //         if (strtolower($tax->type) == 'fixed') {
    //             $totalTax += $tax->value;
    //         } elseif (strtolower($tax->type) == 'percentage') {
    //             $totalTax += ($plan->price * $tax->value) / 100;
    //         }
    //     }

    //     $subscription = Subscription::create([
    //         'plan_id' => $plan_id,
    //         'user_id' => $user->id,
    //         'device_id' => 1,
    //         'start_date' => $start_date,
    //         'end_date' => $end_date,
    //         'status' => 'active',
    //         'amount' => $plan->price,
    //         'discount_percentage' => $plan->discount_percentage,
    //         'tax_amount' => $totalTax,
    //         'total_amount' => $amount,
    //         'name' => $plan->name,
    //         'identifier' => $plan->identifier,
    //         'type' => $plan->duration,
    //         'duration' => $plan->duration_value,
    //         'level' => $plan->level,
    //         'plan_type' => $limitation_data ? json_encode($limitation_data) : null,
    //         'payment_id' => $transaction_id,
    //     ]);

    //     SubscriptionTransactions::create([
    //         'user_id' => $user->id,
    //         'amount' => $amount,
    //         'payment_type' => $payment_type,
    //         'payment_status' => 'paid',
    //         'tax_data' => $taxes->isEmpty() ? null : json_encode($taxes),
    //         'transaction_id' => $transaction_id,
    //         'subscriptions_id' => $subscription->id,
    //     ]);

    //     $response = new SubscriptionResource($subscription);
    //     $this->sendNotificationOnsubscription('new_subscription', $response);

    //     if (isSmtpConfigured()) {
    //         try {
    //             Mail::to($user->email)->send(new SubscriptionDetail($response));
    //         } catch (\Exception $e) {
    //             Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
    //         }
    //     }

    //     $user->update(['is_subscribe' => 1]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Payment completed successfully!',
    //         'subscription' => $response
    //     ]);
    // }
}
