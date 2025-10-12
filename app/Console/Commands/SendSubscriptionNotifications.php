<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Subscriptions\Models\Subscription;
use App\Mail\ExpiringSubscriptionEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;

class SendSubscriptionNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiry_days = intVal((setting('expiry_plan'))) ?? 7;
        $expiryThreshold = Carbon::now()->addDays($expiry_days);
        $userIds = Subscription::where('status', 'active')
            ->where('end_date', '<=', $expiryThreshold)
            ->pluck('user_id')
            ->toArray();
        // Get users with the retrieved user IDs
        $users = User::with('subscriptionPackage')->whereIn('id', $userIds)->get();
        foreach ($users as $user) {
            // Customize email send
            if (isSmtpConfigured()) {
            Mail::to($user->email)->send(new ExpiringSubscriptionEmail($user));
            }
            $notification_data = [
                'id' => optional($user->subscriptionPackage)->id ?? null,
                'user_id' => $user->id ?? null,
                'name' => optional($user->subscriptionPackage)->name ?? null,
                'type' => optional($user->subscriptionPackage)->type ?? null,
                'amount' => optional($user->subscriptionPackage)->amount ?? null,
                'end_date' => optional($user->subscriptionPackage)->end_date ?? null,
                'days' => $expiry_days,
            ];
            $this->SendPushNotification($notification_data);
        }

        $this->info('Subscription notifications sent successfully.');
    }
    protected function SendPushNotification($data){

        $heading = 'Subscription Plan Expired';

        $content = 'Your plan will expire in' . $data['days'] .'day';

        $type = 'Subscription Plan';
        $userId = $data['user_id'];
        $additionalData = json_encode($data);
        return fcm([
    
            "message" => [
                "topic" => 'user_'.$userId,
                "notification" => [
                    "title" =>$heading,
                    "body" => $content,
                ],
                "data" => [                    
                    "sound"=>"default", 
                    "story_id" => "story_12345",
                    "type" => $type,
                    "additional_data" => $additionalData,
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
                ],
                "android" => [
                    "priority" => "high",
                    "notification" => [                        
                        "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
                    ],
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "category" => "Subscription Plan",
                        ],
                    ],
                ],
            ],
            
        ]);
    }
}
