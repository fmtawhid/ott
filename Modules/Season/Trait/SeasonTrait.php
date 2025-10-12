<?php

namespace Modules\Season\Trait;

use Modules\Season\Models\Season;
use App\Jobs\BulkNotification;

trait SeasonTrait
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


    public function getSeasonsList($tv_show_id){

       $curl = curl_init();

       $api_key=gettmdbapiKey();

       curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://api.themoviedb.org/3/tv/'.$tv_show_id.'?api_key='.$api_key,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'GET',
         CURLOPT_HTTPHEADER => array(
           'accept: application/json'
         ),
       ));

       $response = curl_exec($curl);

       curl_close($curl);

       return $response;
    }
}
