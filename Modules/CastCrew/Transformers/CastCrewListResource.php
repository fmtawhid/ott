<?php

namespace Modules\CastCrew\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Models\Entertainment;
use Modules\Entertainment\Transformers\MoviesResource;

class CastCrewListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */



    public function toArray($request)
    {

        $cast_id=$this->id;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'bio' => $this->bio,
            'type' => 'castcrew',
            'place_of_birth' => $this->place_of_birth,
            'dob' => $this->dob,
            'designation' => $this->designation,
            'profile_image' => setBaseUrlWithFileName($this->file_url),
           
        ];
    }
}
