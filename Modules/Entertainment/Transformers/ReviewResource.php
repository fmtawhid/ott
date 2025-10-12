<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    // $timezone = Setting::where('name', 'default_time_zone')->value('val') ?? 'UTC';

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'entertainment_id' => $this->entertainment_id,
            'rating' => $this->rating,
            'review' => $this->review,
            'user_id' => $this->user_id,
            'username' => optional($this->user)->full_name ?? default_user_name(),
            'profile_image' => setBaseUrlWithFileName(optional($this->user)->file_url),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
