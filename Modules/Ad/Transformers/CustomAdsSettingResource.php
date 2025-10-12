<?php

namespace Modules\Ad\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CustomAdsSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $mediaUrl = $this->media;

        if ($this->url_type === 'local') {
            $mediaUrl = Storage::url('streamit-laravel/' . ltrim($this->media, '/'));
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'url_type' => $this->url_type,
            'placement' => $this->placement,
            'media' => $this->url_type =='local' ? setBaseUrlWithFileName($this->media) : $this->media,
            // 'media' => $mediaUrl,
            'redirect_url' => $this->redirect_url,
            // 'duration' => $this->duration,
            // 'skip_enabled' => $this->skip_enabled,
            // 'skip_after' => $this->skip_after,
            'target_content_type' => $this->target_content_type,
            'target_categories' => $this->target_categories,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            // 'created_at' => $this->created_at,
        ];
    }
}
