<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Genres\Transformers\GenresResource;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Entertainment\Transformers\ReviewResource;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Entertainment\Transformers\EpisodeResource;
use Modules\Entertainment\Transformers\TvshowResource;
use Modules\Entertainment\Models\EntertainmentGenerMapping;
use Modules\Entertainment\Models\Entertainment;
use Modules\Subscriptions\Models\Plan;
use Carbon\Carbon;
use Modules\Episode\Models\Episode;
use Modules\Subscriptions\Models\Subscription;

class TvshowDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $genre_data = [];
        $genres = $this->entertainmentGenerMappings;
        foreach($genres as $genre){
            $genre_data[] = $genre->genre;
        }

        $genre_ids = $genres->pluck('genre_id')->toArray();
        $entertaintment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)->pluck('entertainment_id')->toArray();
        $more_items = Entertainment::whereIn('id', $entertaintment_ids)->where('type','tvshow')->where('status',1)->limit(7)->get()->except($this->id);

        $plans = [];
        $plan = $this->plan;
        if($plan){
            $plans = Plan::where('level', '<=', $plan->level)->get();
        }

        $casts = [];
        $directors = [];
        foreach ($this->entertainmentTalentMappings as $mapping) {
            if($mapping->talentprofile){
                
                if ($mapping->talentprofile->type === 'actor') {
                    $casts[] = $mapping->talentprofile;
                } elseif ($mapping->talentprofile->type === 'director') {
                    $directors[] = $mapping->talentprofile;
                }
             }
        }

        $tvShowLinks = [];
        foreach($this->season as $season){
            $episodes = Episode::where('season_id', $season->id)->get();
            $totalEpisodes = $episodes->count();
            $tvShowLinks[] = [
                'season_id' => $season->id,
                'name' => $season->name,
                'short_desc' => $season->short_desc,
                'description' => $season->description,
                'poster_image' => setBaseUrlWithFileName($season->poster_url),
                'trailer_url_type' => $season->trailer_url_type,
                'trailer_url ' => $season->trailer_url_type=='Local' ? setBaseUrlWithFileName($season->trailer_url) : $season->trailer_url,
                'total_episodes' => $totalEpisodes,
                'episodes' => EpisodeResource::collection(
                                    $episodes->take(5)->map(function ($episode) {
                                        return new EpisodeResource($episode, $this->user_id);
                                    })
                                ),
            ];

        }
        $getDeviceTypeData = Subscription::checkPlanSupportDevice($request->user_id);
        $deviceTypeResponse = json_decode($getDeviceTypeData->getContent(), true); // Decode to associative array

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => strip_tags($this->description),
            'trailer_url_type' => $this->trailer_url_type,
            'type' => $this->type,
            'trailer_url' => $this->trailer_url_type=='Local' ? setBaseUrlWithFileName($this->trailer_url) : $this->trailer_url,
            'movie_access' => $this->movie_access,
            'plan_id' => $this->plan_id,
            'plan_level' => $this->plan->level ?? 0,
            'language' => $this->language,
            'imdb_rating' => $this->IMDb_rating,
            'content_rating' => $this->content_rating,
            'duration' => $this->duration,
            'release_date' => $this->release_date,
            'release_year' => Carbon::parse($this->release_date)->year,
            'is_restricted' => $this->is_restricted,
            'video_upload_type' => $this->video_upload_type,
            'video_url_input' => $this->video_upload_type=='Local' ? setBaseUrlWithFileName($this->video_url_input) : $this->video_url_input,
            'enable_quality' => $this->enable_quality,
            'download_url' => $this->download_url,
            'poster_image' =>setBaseUrlWithFileName($this->poster_url),
            'thumbnail_image' =>setBaseUrlWithFileName($this->thumbnail_url),
            'is_watch_list' => $this->is_watch_list ?? false,
            'is_likes' => $this->is_likes ?? false,
            'your_review' => $this->your_review ?? null,
            'genres' => GenresResource::collection($genre_data),
            'plans' => PlanResource::collection($plans),
            'three_reviews' => ReviewResource::collection($this->reviews->take(3)),
            'reviews' => ReviewResource::collection($this->reviews),
            'casts' => CastCrewListResource::collection($casts),
            'directors' => CastCrewListResource::collection($directors),
            'tvShowLinks' => $tvShowLinks,
            'more_items' => TvshowResource::collection($more_items),
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'is_device_supported' => $deviceTypeResponse['isDeviceSupported'],
            
        ];
    }
}
