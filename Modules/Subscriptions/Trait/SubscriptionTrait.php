<?php

namespace Modules\Subscriptions\Trait;

use App\Models\User;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Modules\Subscriptions\Transformers\SubscriptionResource;
use App\Jobs\BulkNotification;

trait SubscriptionTrait
{
    public function getTimeZone()
    {
        $timezone = \App\Models\Setting::first();

        return $timezone->default_time_zone ?? 'UTC';
    }

    public function get_user_active_plan($user_id)
    {
        $get_provider_plan = Subscription::where('user_id', $user_id)->where('status', config('constant.SUBSCRIPTION_STATUS.ACTIVE'))->first();
        $activeplan = null;
        if (! empty($get_provider_plan)) {
            $activeplan = new SubscriptionResource($get_provider_plan);
        }

        return $activeplan;
    }

    public function check_days_left_plan($old_plan)
    {
        $previous_plan_start = $old_plan->start_date;
        $previous_plan_end = new \Carbon\Carbon($old_plan->end_date);
        $new_plan_start = new \Carbon\Carbon(date('Y-m-d H:i:s'));
        $left_days = $previous_plan_end->diffInDays($new_plan_start);

        return $left_days;
    }

    public function get_plan_expiration_date($plan_start_date = '', $plan_type = '', $plan_duration = 1)
    {
        $start_at = new \Carbon\Carbon($plan_start_date);
        $plan_duration = (int) $plan_duration;
        $end_date = '';

        if ($plan_type === 'month') {

            $end_date = $start_at->addMonths($plan_duration);
        }
        if ($plan_type == 'year') {
            $end_date = $start_at->addYears($plan_duration);
        }if ($plan_type == 'week') {
            $end_date = $start_at->addWeeks($plan_duration);
        }

        return $end_date->format('Y-m-d H:i:s');
    }

    public function send_mail($user_id)
    {
        try {
            $user = User::where('id', $user_id)->first();

            $subject = 'Your Trail Subscribe Plan will expire in 2 Days';
            $message = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";

            \Mail::send('subscription.subscription_email',
                [
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'subject' => $subject,
                    'phone_no' => $user['phone_no'],
                    'message' => $message,
                ], function ($message) use ($user) {
                    $message->from($user->email);
                    $message->to(env('MAIL_FROM_ADDRESS'));
                });

            return $messagedata = __('messages.contact_us_greetings');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return $messagedata = __('messages.something_wrong');
        }
    }
    public function sendNotificationOnsubscription($type,$response){

        $data = mail_footer($type, $response);

        $data['subscription'] = $response;

        BulkNotification::dispatch($data);
    }
}
