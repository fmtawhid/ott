<?php

namespace Modules\User\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Page\Transformers\PageResource;

class AccountSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'is_parental_lock_enable'=> $this->is_parental_lock_enable ?? null,
            'plan_details' => $this->plan_details ?? null,
            'register_mobile_number' => $this->mobile,
            'your_device' => $this->your_device ?? null,
            'other_device' => $this->other_device ?? null,
            'page_list'=>PageResource::collection($this->page)
        ];
    }
}
