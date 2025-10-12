<?php

namespace Modules\Episode\Trait;

use Modules\Episode\Models\Episode;
use App\Jobs\BulkNotification;

trait EpisodeTrait
{
   

    public function SendPushNotification($data)
    {
        $heading = [
            "en" => $data['name']
        ];

        $content = [
            "en" => $data['description']
        ];

        return fcm([
            'to' => 'all_user',
            'collapse_key' => 'type_a',
            'notification' => [
                'body' => $content,
                'title' => $heading,
            ],
        ]);
    }
}
