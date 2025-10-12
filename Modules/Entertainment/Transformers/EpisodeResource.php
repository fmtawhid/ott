<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Models\Entertainment;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Entertainment\Models\EntertainmentDownload;

class EpisodeResource extends JsonResource
{
    protected $userId;
    public function __construct($resource, $userId = null)
    {
        parent::__construct($resource);
        $this->userId = $userId;
    }

    public function toArray($request)
    {
        if($this->userId){
            $is_download = EntertainmentDownload::where('entertainment_id', $this->id)->where('user_id', $this->userId)->where('entertainment_type', 'episode')->where('is_download', 1)->exists();
        }
        // dd($this->userId);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'entertainment_id' => $this->entertainment_id,
            'season_id' => $this->season_id,
            'trailer_url_type' => $this->trailer_url_type,
            'type'=>'episode',
            'trailer_url' => $this->trailer_url_type=='Local' ? setBaseUrlWithFileName($this->trailer_url) : $this->trailer_url,
            'access' => $this->access,
            'plan_id' => $this->plan_id,
            'imdb_rating' => $this->IMDb_rating,
            'content_rating' => $this->content_rating,
            'duration' => $this->duration,
            'release_date' => $this->release_date,
            'is_restricted' => $this->is_restricted,
            'short_desc' => $this->short_desc,
            'description' => strip_tags($this->description),
            'video_upload_type' => $this->video_upload_type,
            'video_url_input' => $this->video_upload_type=='Local' ? setBaseUrlWithFileName($this->video_url_input) : $this->video_url_input,
            'download_status' => $is_download ?? false,
            'enable_quality' => $this->enable_quality,
            'download_url' => $this->download_url,
            'poster_image' =>  setBaseUrlWithFileName($this->poster_url),
            'video_links' => $this->EpisodeStreamContentMapping ?? null,
            'plan' => new PlanResource($this->plan),
            'thumbnail_image' => setBaseUrlWithFileName($this->thumbnail_url),
            'poster_tv_image' =>  setBaseUrlWithFileName($this->poster_tv_url),
            'price' => (float)$this->price,
            'discounted_price' => round((float)$this->price - ($this->price * ($this->discount / 100)), 2),
            'purchase_type' => $this->purchase_type,
            'access_duration' => $this->access_duration,
            'discount'=> (float)$this->discount,
            'available_for' => $this->available_for,
            'is_purchased' => Entertainment::isPurchased($this->id,'episode', $this->user_id ?? $this->userId ),
            'subtitle_info' => $this->enable_subtitle == 1 ? SubtitleResource::collection($this->subtitles) : null,

        ];
    }
}
