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

class TvshowDetailResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $genre_data = [];
        // $genres = $this->entertainmentGenerMappings;
        // foreach($genres as $genre){
        //     $genre_data[] = $genre->genre;
        // }



        // $genre_ids = $genres->pluck('genre_id')->toArray();
        $entertaintment_ids = EntertainmentGenerMapping::whereRaw('genre_id IN ('.$this->genre_ids.')')->pluck('entertainment_id')->toArray();

        $more_items = Entertainment::whereIn('id', $entertaintment_ids)
            ->where('type','tvshow');

            isset(request()->is_restricted) && $more_items = $more_items->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $more_items = $more_items->where('is_restricted',0);

         $more_items = $more_items->where('status',1)
            ->limit(7)->get()
            ->except($this->id);

        $plans = [];
        // $plan = $this->plan;
        // if($plan){
        //     $plans = Plan::where('level', '<=', $plan->level)->get();
        // }

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
        foreach($this->season as $season)
        {

            $episodes = Episode::selectRaw('episodes.*,plan.level as plan_level, (CASE WHEN (select exists(select id from `entertainment_downloads` where `entertainment_id` = '.$this->id.' AND `user_id` = "'.$this->userId.'" AND `entertainment_type` = "episode" AND is_download = 1 LIMIT 1)) THEN 1 ELSE 0 END) AS is_download')
            ->leftJoin('plan','plan.id','=','episodes.plan_id');

            isset(request()->is_restricted) && $episodes = $episodes->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $episodes = $episodes->where('is_restricted',0);

            $episodes = $episodes->where('season_id', $season->id)
            ->get();

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
                'episodes' => self::getEpisodes($episodes->take(5))
            ];

        }
        $header = request()->headers->all();
        $device_type = !empty($header['device-type'])? $header['device-type'][0] : []; //for tv
        $getDeviceTypeData = Subscription::checkPlanSupportDevice($request->user_id,$device_type);
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
            'plan_level' => $this->plan_level,
            'language' => $this->language,
                'imdb_rating' => $this->IMDb_rating ?? $this->imdb_rating,
            'content_rating' => $this->content_rating,
            'duration' => $this->duration,
            'release_date' => $this->release_date,
            'release_year' => $this->release_year,
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
            'genres' =>  self::getGenes($this->genres),
            // GenresResource::collection($this->genres),
                // 'plans' => PlanResource::collection($plans),
            'three_reviews' => ReviewResource::collection($this->reviews->take(3)),
            'reviews' => ReviewResource::collection($this->reviews),
            'casts' => CastCrewListResource::collection($casts),
            'directors' => CastCrewListResource::collection($directors),
            'tvShowLinks' => $tvShowLinks,
            // 'more_items' => TvshowResource::collection($more_items),
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
           'is_device_supported' => $deviceTypeResponse['isDeviceSupported'],
           'price' => (float)$this->price,
           'discounted_price' => round((float)$this->price - ($this->price * ($this->discount / 100)), 2),
            'purchase_type' => $this->purchase_type,
            'access_duration' => $this->access_duration,
            'discount'=> (float)$this->discount,
            'available_for' => $this->available_for,
            'is_purchased' => $this->isPurchased($this->id,$this->type,$this->user_id),
        ];
    }

    public static function getGenes($genres)
    {
        $result = [];
        if(count($genres) > 0)
        {
            foreach($genres as $key=>$val)
            {
                $result[] = [
                    'id' => $val['id'] ?? null,
                    'name' => $val['name'] ?? null,
                    'genre_image' => !empty($val['file_url']) ? setBaseUrlWithFileName($val['file_url']) : null,
                    'status' => $val['status'] ?? null,
                ];
            }
        }
        return $result;
    }

    public static function getEpisodes($resultData)
    {
        $result = [];
        if(count($resultData) > 0)
        {
            foreach($resultData as $key=>$val)
            {
                $result[] = [
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'entertainment_id' => $val['entertainment_id'],
                    'season_id' => $val['season_id'],
                    'trailer_url_type' => $val['trailer_url_type'],
                    'type'=>'episode',
                    'trailer_url' => $val['trailer_url_type']=='Local' ? setBaseUrlWithFileName($val['trailer_url']) : $val['trailer_url'],
                    'access' => $val['access'],
                    'plan_id' => $val['plan_id'],
                    'plan_level' => $val['plan_level'],
                    'imdb_rating' => $val['IMDb_rating'],
                    'content_rating' => $val['content_rating'],
                    'duration' => $val['duration'],
                    'release_date' => $val['release_date'],
                    'is_restricted' => $val['is_restricted'],
                    'short_desc' => $val['short_desc'],
                    'description' => strip_tags($val['description']),
                    'video_upload_type' => $val['video_upload_type'],
                    'video_url_input' => $val['video_upload_type']=='Local' ? setBaseUrlWithFileName($val['video_url_input']) : $val['video_url_input'],
                    'download_status' => $val['is_download'] ?? false,
                    'enable_quality' => $val['enable_quality'],
                    'download_url' => $val['download_url'],
                    'poster_image' =>  setBaseUrlWithFileName($val['poster_url']),
                    'video_links' => $val->EpisodeStreamContentMapping ?? 'null',
                ];
            }
        }
        return $result;
    }
}
