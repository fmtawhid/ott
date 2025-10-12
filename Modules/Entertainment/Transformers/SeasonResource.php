<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Subscriptions\Transformers\PlanResource;

class SeasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'entertainment_id' => $this->entertainment_id,
            'trailer_url_type' => $this->trailer_url_type,
            'type'=>'season',
            'trailer_url' => $this->trailer_url_type=='Local' ? setBaseUrlWithFileName($this->trailer_url) : $this->trailer_url,
            'access' => $this->access,
            'plan_id' => $this->plan_id,
            'short_desc' => $this->short_desc,
            'description' => strip_tags($this->description),
            'poster_image' =>setBaseUrlWithFileName($this->poster_url),
            'plan' => new PlanResource($this->plan),
            'poster_tv_image' => setBaseUrlWithFileName($this->poster_tv_url),
        ];
    }
}
