<?php

namespace Modules\Video\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Entertainment\Models\Watchlist;
use Modules\Subscriptions\Models\Plan;
use Modules\Entertainment\Models\Entertainment;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $plans = [];
        $plan = $this->plan;
        if($plan){
            $plans = Plan::where('level', '<=', $plan->level)->get();
        }
        $userId = auth()->id();
        $isInWatchList = $userId ? WatchList::where('entertainment_id', $this->id)
            ->where('user_id', $userId)
            ->exists() : false;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'trailer_url_type' => $this->trailer_url_type,
            'trailer_url' => $this->trailer_url_type=='Local' ? setBaseUrlWithFileName($this->trailer_url) : $this->trailer_url,
            'access' => $this->access,
            'plan_id' => $this->plan_id,
            'type'=>'video',
            'plan_level' => $this->plan->level ?? 0,
            'imdb_rating' => $this->IMDb_rating,
            'content_rating' => $this->content_rating,
            'duration' => $this->duration,
            'release_date' => $this->release_date,
            'is_restricted' => $this->is_restricted,
            'short_desc' => $this->short_desc,
            'description' => strip_tags($this->description),
            'enable_quality' => $this->enable_quality,
            'video_upload_type' => $this->video_upload_type,
            'download_status' => $this->download_status,
            'download_url' => $this->download_url,
            'poster_image' => setBaseUrlWithFileName($this->poster_url),
            'plans' => PlanResource::collection($plans),
            'status' => $this->status,
            'is_watch_list' => $isInWatchList,
            'thumbnail_image' => setBaseUrlWithFileName($this->thumbnail_url),
            'poster_tv_image' => setBaseUrlWithFileName($this->poster_tv_url),
            'price' => (float)$this->price,
            'discounted_price' => round((float)$this->price - ($this->price * ($this->discount / 100)), 2),
            'purchase_type' => $this->purchase_type,
            'access_duration' => $this->access_duration,
            'discount'=> (float)$this->discount,
            'available_for' => $this->available_for,
            'is_purchased' => Entertainment::isPurchased($this->id,'video',$request->user_id ?? $this->user_id ?? null),
            'video_url_input' => $this->video_upload_type=='Local' ? setBaseUrlWithFileName($this->video_url_input) : $this->video_url_input, // sandip sir chnages
        ];
    }
}
