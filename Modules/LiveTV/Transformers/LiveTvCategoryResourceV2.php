<?php

namespace Modules\LiveTV\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\LiveTV\Models\LiveTvCategory;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Transformers\LiveTvChannelResource;

class LiveTvCategoryResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'category_image' => setBaseUrlWithFileName($this->file_url),
            'channel_data' => LiveTvChannelResource::collection(LiveTvChannel::get_tvChannels_catgory_wise($this->id)),
            'status' => $this->status,
        ];
    }
}
