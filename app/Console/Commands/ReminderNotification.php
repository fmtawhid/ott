<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Entertainment\Models\UserReminder;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use App\Models\User;
use Carbon\Carbon;

class ReminderNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:notify';

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
        $days = intVal((setting('upcoming'))) ?? 1;

        $thresholdDate = Carbon::now()->addDays($days)->startOfDay();
        $reminder_data = UserReminder::with('entertainment')->whereDate('release_date', '=', $thresholdDate)->where('is_remind',1)->get();

        foreach ($reminder_data as $reminder) {
            $user = User::where('id', $reminder->user_id)->first();
            
            $entertainment = $reminder->entertainment;
            if (isSmtpConfigured()) {
            Mail::to($user->email)->send(new ReminderEmail($user));
            }
            $notification_data = [
                'id' => $entertainment->id ?? null,
                'user_id' => $reminder->user_id,
                'name' => $entertainment->name ?? null,
                'posterimage' => $entertainment->poster_url ?? null,
                'type' => $entertainment->type ?? null,
                'release_date' => $entertainment->release_date ?? null,
                'description' => $entertainment->description ?? null,
                'days'=> $days,
            ];
            $this->SendPushNotification($notification_data);
        }

        $this->info('Reminder notifications sent successfully.');
    }
    protected function SendPushNotification($data){

        $heading = 'Movie ' . ($data['name'] ?? '') . ' release in ' . $data['days'] .'day';

        $content = strip_tags($data['description'] ?? '');

        $type = 'Reminder';
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
                            "category" => "Reminder",
                        ],
                    ],
                ],
            ],
            
        ]);
    }
}
