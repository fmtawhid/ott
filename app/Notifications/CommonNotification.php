<?php

namespace App\Notifications;

use App\Broadcasting\CustomWebhook;

use App\Mail\MailMailableSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\NotificationTemplate\Models\NotificationTemplate;
use Spatie\WebhookServer\WebhookCall;
use App\Broadcasting\FcmChannel;

class CommonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $type;

    public $data;

    public $subject;

    public $notification;

    public $notification_message;

    public $notification_link;

    public $appData;

    public $custom_webhook;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
        $this->notification = NotificationTemplate::where('type', $this->type)->with('defaultNotificationTemplateMap')->first();
        $this->subject = $this->notification->defaultNotificationTemplateMap->subject;
        $this->type = ucwords(str_replace('_', ' ', $this->notification->type)) . '!';
        $this->notification_message = $this->notification->defaultNotificationTemplateMap->notification_message;
        $this->notification_link = $this->notification->defaultNotificationTemplateMap->notification_link;
        // foreach ($this->data as $key => $value) {
        //     $this->subject = str_replace('[[ ' . $key . ' ]]', $this->data[$key], $this->subject);
        //     $this->notification_message = str_replace('[[ ' . $key . ' ]]', $this->data[$key], $this->notification_message);
        //     $this->notification_link = str_replace('[[ ' . $key . ' ]]', $this->data[$key], $this->notification_link);
        // }
        $this->subject = $this->subject != '' ? $this->subject : 'None';
        $this->notification_message = $this->notification_message != '' ? $this->notification_message : __('messages.default_notification_body');
        $this->appData = $this->notification->channels;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $notificationSettings = $this->appData;
        $notification_settings = [];
        $notification_access = isset($notificationSettings[$this->type]) ? $notificationSettings[$this->type] : [];
        if (isset($notificationSettings)) {
            foreach ($notificationSettings as $key => $notification) {
                if ($notification) {
                    switch ($key) {

                        case 'PUSH_NOTIFICATION':
                            array_push($notification_settings, FcmChannel::class);

                            break;

                        case 'IS_CUSTOM_WEBHOOK':
                            array_push($notification_settings, CustomWebhook::class);

                            break;

                        case 'IS_MAIL':
                            array_push($notification_settings, 'mail');

                            break;
                    }
                }
            }
        }

        return array_merge($notification_settings, ['database']);
    }


    /**
     * Get mail notification
     *
     * @param  mixed  $notifiable
     * @return MailMailableSend
     */
    public function toMail($notifiable)
    {
        $email = '';

        if (isset($notifiable->email)) {
            $email = $notifiable->email;
        } else {
            $email = $notifiable->routes['mail'];
        }

     

        return (new MailMailableSend($this->notification, $this->data, $this->type))->to($email)
            ->bcc(isset($this->notification->bcc) ? json_decode($this->notification->bcc) : [])
            ->cc(isset($this->notification->cc) ? json_decode($this->notification->cc) : [])
            ->subject($this->subject);
    }

    public function toWebhook($notifiable)
    {
        $key = setting('custom_webhook_content_key');
        $url = setting('custom_webhook_url');
        $secrate_key = setting('app_name');
        $msg = 'Subject: ' . $this->subject . "\nDescription: " . strip_tags($this->notification_message) . "\n" . 'Link: ' . $this->notification_link;

        return WebhookCall::create()
            ->url($url)
            ->payload([$key => $msg])
            ->useSecret($secrate_key)
            ->dispatch();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'data' => $this->data,
        ];
    }

    public function toFcm($notifiable)
    {
        $msg = $this->subject;
        if (!isset($msg) && $msg == '') {
            $msg = __('message.notification_body');
        }
        $type = '';
        if (isset($this->data['type']) && $this->data['type'] !== '') {
            $type = $this->data['type'];
        }
        $heading = $this->subject;

        return $this->fcm([
            'to' => '/topics/user_' . $notifiable->id,
            'collapse_key' => 'type_a',
            'notification' => [
                'body' =>  $msg,
                'title' => $heading,
            ],
            'data' => [
                'type' => $this->subject,
                'additional_data' => $this->data
            ],
        ]);
    }

    function fcm($fields)
    {
        $headers = [
            'Authorization: key=' . setting('firebase_key'),
            'Content-Type: application/json',
        ];

        $ch = curl_init('https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $response = curl_exec($ch);
        curl_close($ch);
    }
}
