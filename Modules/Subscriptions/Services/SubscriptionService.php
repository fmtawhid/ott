<?php

namespace Modules\Subscriptions\Services;

use App\Mail\SubscriptionDetail;
use App\Models\User;
use Modules\Subscriptions\Repositories\SubscriptionRepositoryInterface;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Currency\Models\Currency;
use Modules\Subscriptions\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\Models\Payment;
use Currency as CurrencyFormat;
use Illuminate\Support\Facades\Mail;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Models\SubscriptionTransactions;
use Modules\Subscriptions\Trait\SubscriptionTrait;
use Modules\Subscriptions\Transformers\PlanlimitationMappingResource;
use Modules\Subscriptions\Transformers\SubscriptionResource;
use Illuminate\Support\Facades\Log;
use Modules\Tax\Models\Tax;
use Illuminate\Contracts\Support\Renderable;


class SubscriptionService
{
    use SubscriptionTrait;

    protected $subscriptionRepository;

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getAllPayments()
    {
        return $this->SubscriptionRepository->all();
    }

    public function getPaymentById($id)
    {
        $subscription = $this->subscriptionRepository->find($id);

        $subscription->amount_display = Currency::format($subscription->currency) . ' ' . $subscription->amount;

        $plans = Plan::where('status', 1)->get();

        $users = User::role('user')->where('status',1)->get();

        $mediaUrls = getMediaUrls();

        return compact('subscription', 'plans', 'users', 'mediaUrls');
    }
    
    public function createPayment(array $data)
    {
        $user = User::find($data['user_id']);
        $currency = Currency::where('is_primary', 1)->first();
        $data['currency'] = $currency ? strtolower($currency->currency_code) : 'inr';
    
        if (!empty($data['file_url'])) {
            $data['file_url'] = extractFileNameFromUrl($data['file_url']);
        }
        $plan = Plan::find($data['plan_id']);
        $data['plan_details'] = $plan ? json_encode($plan) : null;
        $data['payment_method'] = 1;   
        $data['is_manual'] = 1; 
        $deviceIds = $user->devices->pluck('device_id');

        $start_date = $data['payment_date'];
        $end_date = $this->get_plan_expiration_date($start_date, $plan->duration, $plan->duration_value);
    
        $limitation_data = PlanlimitationMappingResource::collection($plan->planLimitation);
        $taxes = Tax::active()->get();
        $planAmount = $plan->discount ? $plan->total_price : $plan->price;
        $totalTax = 0;
    
        foreach ($taxes as $tax) {
            if (strtolower($tax->type) === 'fixed') {
                $totalTax += $tax->value;
            } elseif (strtolower($tax->type) === 'percentage') {
                $totalTax += ($planAmount * $tax->value) / 100;
            }
        }
        $data['device_id'] = $deviceIds->first() ?? 0;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['amount'] = $planAmount;
        $data['tax_amount'] = $totalTax;
        $data['discount_percentage'] = $plan->discount_percentage ?? 0;
        $data['total_amount'] = $planAmount + $totalTax;
        $data['name'] = $plan->name;
        $data['identifier'] = $plan->identifier;
        $data['type'] = $plan->duration;
        $data['duration'] = $plan->duration_value;
        $data['level'] = $plan->level;
        $data['plan_type'] = $limitation_data ? json_encode($limitation_data) : null;
        $data['status'] = 'inactive';
        
        $subscription = $this->subscriptionRepository->create($data);
        
        $transaction = SubscriptionTransactions::create([
            'user_id' => $subscription->user_id,
            'amount' => $subscription->total_amount,
            'payment_type' => 'cash', 
            'payment_status' => 'paid', 
            'subscriptions_id' => $subscription->id,
        ]);
    
        $payment_id = $transaction->id;
        if ($transaction->payment_status === 'paid') {
            $subscription->update([
                'status' => 'active',
                'payment_id' => $transaction->id,
            ]);
        }
        Subscription::where('user_id', $subscription->user_id)
            ->where('id', '!=', $subscription->id)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $response = new SubscriptionResource($subscription);
        
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
        $user->update(['is_subscribe' => 1]);
    }
    
    
   public function updatePayment(array $data)
    {
        if (!empty($data['file_url'])) {
            $data['file_url'] = extractFileNameFromUrl($data['file_url']);
        }

        $currency = Currency::where('is_primary', 1)->first();
        $data['currency'] = $currency ? strtolower($currency->currency_code) : 'inr';

        $plan = Plan::find($data['plan_id']);
        $data['plan_details'] = $plan ? json_encode($plan) : null;

        $data['payment_method'] = 1;
        $planAmount = $plan->discount ? $plan->total_price : $plan->price;
        $taxes = Tax::active()->get();
        $totalTax = 0;

        foreach ($taxes as $tax) {
            if (strtolower($tax->type) === 'fixed') {
                $totalTax += $tax->value;
            } elseif (strtolower($tax->type) === 'percentage') {
                $totalTax += ($planAmount * $tax->value) / 100;
            }
        }

        $data['amount'] = $planAmount;
        $data['tax_amount'] = $totalTax;
        $data['total_amount'] = $planAmount + $totalTax;
        $data['discount_percentage'] = $plan->discount_percentage ?? 0;

        return $this->subscriptionRepository->update($data['id'], $data);
    }

    public function deletePayment($id)
    {
        return $this->subscriptionRepository->delete($id);
    }

    public function restorePayment($id)
    {
        return $this->subscriptionRepository->restore($id);
    }

    public function forceDeletePayment($id)
    {
        return $this->subscriptionRepository->forceDelete($id);
    }
}
