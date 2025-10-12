<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use App\Services\FirebaseService;

// class FCM extends Model
// {
//     protected $table = 'fcm';

//     protected $fillable = [
//         'title',
//         'message',
//         'image',
//     ];

//     protected static function booted()
//     {
//         static::created(function ($notification) {
//             $firebase = app(FirebaseService::class);

//             $firebase->pushData([
//                 'title' => $notification->title,
//                 'message' => $notification->message,
//                 'image' => $notification->image,
//                 'created_at' => now()->toDateTimeString(),
//             ]);

//             $firebase->sendNotification($notification->title, $notification->message, $notification->image);
//         });

//     }
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\FirebaseService;

class FCM extends Model
{
    protected $table = 'fcm'; 
    protected $fillable = ['title', 'message', 'image'];

    protected static function booted()
    {
        static::created(function ($notification) {
            $firebase = app(FirebaseService::class);

            // শুধু notification পাঠানো
            $firebase->sendNotification(
                $notification->title,
                $notification->message,
                $notification->image
            );
        });
    }
}
 