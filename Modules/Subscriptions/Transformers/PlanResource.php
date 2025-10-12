<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'plan_id' => $this->id,
            'name' => $this->name,
            'identifier' => $this->identifier,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_percentage' => intval($this->discount_percentage),
            'total_price' => $this->total_price,
            'level' => $this->level,
            'duration' => $this->duration,
            'duration_value' => $this->duration_value,
            'description' => strip_tags($this->description),
            'plan_type' => PlanlimitationMappingResource::collection($this->planLimitation),
            'android_identifier' => $this->android_identifier,
            'apple_identifier' => $this->apple_identifier,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
