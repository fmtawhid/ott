<?php

// namespace App\Services;

// use Kreait\Firebase\Factory;
// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\Notification;

// class FirebaseService
// {
//     protected $messaging;

//     public function __construct()
//     {
//         $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
//         $this->messaging = $factory->createMessaging();
//     }

//     // Firebase Realtime Database বা Firestore push (যদি দরকার হয়)
//     public function pushData(array $data)
//     {
//         // যদি তুমি Realtime Database ব্যবহার করো:
//         $database = (new Factory)
//             ->withServiceAccount(config('firebase.credentials'))
//             ->withDatabaseUri(config('firebase.database.url'))
//             ->createDatabase();

//         // এখানে push করে 'notifications' node তে
//         $database->getReference('notifications')->push($data);
//     }

//     // Send push notification to all devices (FCM token)
//     public function sendNotification(string $title, string $body, ?string $image = null)
//     {
//         // Topic broadcast to all devices, যেমন /topics/all
//         $message = CloudMessage::withTarget('topic', 'all')
//             ->withNotification(Notification::create($title, $body));

//         if ($image) {
//             $message = $message->withData(['image' => $image]);
//         }

//         $this->messaging->send($message);
//     }
// }

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
        $this->messaging = $factory->createMessaging();
    }
 
    // শুধুমাত্র notification পাঠানোর method
    public function sendNotification(string $title, string $body, ?string $image = null)
    {
        $message = CloudMessage::withTarget('topic', 'all')
            ->withNotification(Notification::create($title, $body));

        if ($image) {
            $message = $message->withData(['image' => $image]);
        }

        $this->messaging->send($message);
    }
}
