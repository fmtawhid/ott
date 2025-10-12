<?php

namespace Modules\Ad\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VastAdsSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
         return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'url' => $this->url,
            'duration' => $this->duration,
            'target_type' => $this->target_type,
            'target_selection' => json_decode($this->target_selection, true),
            'enable_skip' => $this->enable_skip,
            'skip_after' => $this->skip_after,
            'frequency' => $this->frequency,
            'is_enable' => $this->is_enable,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
