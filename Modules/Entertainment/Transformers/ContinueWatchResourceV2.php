<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Genres\Transformers\GenresResource;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Subscriptions\Models\Plan;

class ContinueWatchResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $entertainment = null;
        $plans = [];
        // $genres = \DB::table('genres')->get()->keyBy('id');
        // $genres = \DB::table('entertainment_gener_mapping')
        //         ->selectRaw('genres.*')
        //         ->leftJoin('genres','genres.id','entertainment_gener_mapping.genre_id')
        //         ->where('entertainment_id',$this->entertainment_id)
        //         ->get()
        //         ->toArray();

        if($this->entertainment_type == 'movie'){
            $entertainment = $this->entertainmentNew;
        }
        else if($this->entertainment_type == 'tvshow'){
            $entertainment = $this->episodeNew;
        }
        else if($this->entertainment_type == 'video'){
            $entertainment = $this->videoNew;
        }

        return [
            'id' => $this->id,
            'entertainment_id' => $this->entertainment_id,
            'user_id' => $this->user_id,
            'entertainment_type' => $this->entertainment_type,
            'watched_time' => $this->watched_time ?? '00:00:01',
            'total_watched_time' => $this->total_watched_time ?? '00:00:01',
            'episode_id' => $this->episode_id ?? null,
            'name' => $entertainment->name ?? null,
            'description' => strip_tags($entertainment->description ?? null),
            'trailer_url_type' => $entertainment->trailer_url_type ??null ,
            'trailer_url' => isset($entertainment) && $entertainment->trailer_url_type == 'Local'
    ? setBaseUrlWithFileName($entertainment->trailer_url)
    : ($entertainment->trailer_url ?? null),
            'plan_id' => $entertainment->plan_id ?? null,
            'is_restricted' => $entertainment->is_restricted ?? null,
            'video_upload_type' => $entertainment->video_upload_type ?? null,
            'video_url_input' => isset($entertainment) && $entertainment->video_upload_type == 'Local'  ? setBaseUrlWithFileName($entertainment->video_url_input) : ($entertainment->video_url_input ?? null),
            'poster_image' =>  setBaseUrlWithFileName($entertainment->poster_url ?? null ),
            'thumbnail_image' =>setBaseUrlWithFileName($entertainment->thumbnail_url ?? null),
            'status' => $entertainment->status ?? null,
        ];
    }
}
