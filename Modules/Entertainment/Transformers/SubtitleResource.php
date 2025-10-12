<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubtitleResource extends JsonResource
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
            'type' => $this->type,
            'language' => $this->language,
            'language_code' => $this->language_code,
            'subtitle_file' => setBaseUrlSubtitleFile($this->subtitle_file),
            'is_default'=>$this->is_default
           

        ];
    }
}
