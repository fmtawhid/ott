<?php

namespace Modules\Entertainment\Trait;

use Modules\Entertainment\Models\EntertainmentGenerMapping;
use Modules\Entertainment\Models\EntertainmentTalentMapping;
use App\Jobs\BulkNotification;

trait EntertainmentTrait
{
    public function saveGenreMappings(array $genres, int $entertainmentId)
    {
        
        foreach($genres as $genre){

            $genre_data=[
                'entertainment_id'=>$entertainmentId,
                'genre_id'=> $genre
                
            ];

           EntertainmentGenerMapping::create($genre_data);
        }
    }


    
    public function saveTalentMappings(array $talents, int $entertainmentId)
    {

        
        foreach($talents as $talent){

            $talent_data=[
                'entertainment_id'=>$entertainmentId,
                'talent_id'=> $talent
                
            ];

            EntertainmentTalentMapping::create($talent_data);
        }
    
      
    }
    function SendPushNotification($data){
        $heading = array(
            "en" => $data['name']
        );
        
        $content = array(
            "en" => $data['description']
        );
        return fcm([
    
            'to'=>'all_user',
            'collapse_key' => 'type_a',
            'notification' => [
                'body' =>  $content,
                'title' => $heading ,
            ],
            
        ]);
    }
}
