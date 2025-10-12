<?php

namespace Modules\LiveTV\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Subscriptions\Models\Plan;

class LiveTvChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        // $plans = [];


        // $plan = $this->plan;


        // if($plan){
        //     $plans = Plan::where('level', '<=', $plan->level)->get();
        // }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'plan_id' => $this->plan_id,
            'plan_level' => $this->plan->level ?? 0,
            'description' => strip_tags($this->description),
            'poster_image' => setBaseUrlWithFileName($this->poster_url),
            'category' => optional($this->TvCategory)->name ?? null,
            'stream_type' => optional($this->TvChannelStreamContentMappings)->stream_type ?? null,
            'embedded' => optional($this->TvChannelStreamContentMappings)->embedded ?? null,
            'server_url' => optional($this->TvChannelStreamContentMappings)->server_url ?? null,
            'server_url1' => optional($this->TvChannelStreamContentMappings)->server_url1 ?? null,
            // 'plans' => PlanResource::collection($plans),
            'status' => $this->status,
            'access'=>$this->access,
            'poster_tv_image' => setBaseUrlWithFileName($this->poster_tv_url),
        ];
    }
}
