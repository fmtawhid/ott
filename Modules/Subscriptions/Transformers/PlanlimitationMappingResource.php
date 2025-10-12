<?php

namespace Modules\Subscriptions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanlimitationMappingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */

    public function toArray($request): array
    {
        $message = null;
        $slug = optional($this->limitation_data)->slug;

        switch ($slug) {
            case 'video-cast':
                $message = $this->limitation_value
                    ? 'Cast videos to your TV with ease.'
                    : 'Video casting is not available with this plan.';
                break;
            case 'ads':
                $message = $this->limitation_value
                    ? 'This plan includes ads.'
                    : 'Ad-free streaming with this plan.';
                break;
            case 'device-limit':
                $message = $this->limitation_value
                    ? 'Stream on up to '. $this->limit.' devices simultaneously.'
                    : 'This plan can only be used on one device.';
                break;
            case 'download-status':
                $message = $this->limitation_value
                    ? 'Enjoy unlimited downloads with this plan.'
                    : 'Download feature is not available with this plan.';
                break;
         }

        
        $limit = ($slug === 'device-limit' || $slug === 'profile-limit')
        ? ['value' => (string)$this->limit]
        : json_decode($this->limit, true); 

        return [

            'id' => $this->id,
            'planlimitation_id'=>$this->planlimitation_id,
            'limitation_title'=>optional($this->limitation_data)->title,
            'limitation_value' => $this->limitation_value, 
            'limit' =>$limit,
            // 'download_option' => optional($this->limitation_data)->slug === 'download-status' ? json_decode($this->limit) : null,
            // 'supported_devices' => optional($this->limitation_data)->slug === 'supported-device-type' ? json_decode($this->limit) : null,
            'slug'=>optional($this->limitation_data)->slug,
            'status' => optional($this->limitation_data)->status,
            'message' => $message,

        ];
    }
}
