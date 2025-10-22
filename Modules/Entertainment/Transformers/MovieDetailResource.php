<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Genres\Transformers\GenresResource;
use Modules\Subscriptions\Transformers\PlanResource;
use Modules\Entertainment\Transformers\ReviewResource;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Entertainment\Models\EntertainmentGenerMapping;
use Modules\Entertainment\Models\Entertainment;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;

use Carbon\Carbon;
use Modules\Entertainment\Transformers\ContinueWatchResource;
use Modules\Entertainment\Models\EntertainmentDownload;


class MovieDetailResource  extends JsonResource
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

        // $genre_ids = $genres->pluck('genre_id')->toArray();
        // $entertaintment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)->pluck('entertainment_id')->toArray();
        // $more_items = Entertainment::whereIn('id', $entertaintment_ids)->where('type','movie')->where('status',1)->limit(7)->get()->except($this->id);

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

        $downloadMappings = $this->entertainmentDownloadMappings ? $this->entertainmentDownloadMappings->toArray() : [];

        if ($this->download_status == 1) {

            if($this->download_type != null &&  $this->download_url !=null){

            $downloadData = [
                'type' => $this->download_type,
                'url' => $this->download_url,
                'quality' => 'default',
            ];
            $downloadMappings[] = $downloadData;
         }
        }
        $download = EntertainmentDownload::where('entertainment_id', $this->entertainment_id)->where('user_id',  $this->user_id)->where('entertainment_type', 'episode')->where('is_download', 1)->first();
        $getDeviceTypeData = Subscription::checkPlanSupportDevice($request->user_id);
        $deviceTypeResponse = json_decode($getDeviceTypeData->getContent(), true); // Decode to associative array
        // dd($this->subtitles);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug, // <-- Add this line
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
            'watched_time' => optional($this->continue_watch)->watched_time ?? null,
            'duration' => $this->duration,
            'release_date' => $this->release_date,
            'release_year' => Carbon::parse($this->release_date)->year,
            'is_restricted' => $this->is_restricted,
            'video_upload_type' => $this->video_upload_type,
            'video_url_input' => $this->video_upload_type=='Local' ? setBaseUrlWithFileName($this->video_url_input) : $this->video_url_input,
            'enable_quality' => $this->enable_quality,
            'is_download' => $this->is_download ?? false,
            'download_status' => $this->download_status,
            'download_type' => $this->download_type,
            'download_url' => $this->download_url,
            'enable_download_quality' => $this->enable_download_quality,
            'download_quality' => $downloadMappings,
            'poster_image' => setBaseUrlWithFileName($this->poster_url),
            'thumbnail_image' => setBaseUrlWithFileName($this->thumbnail_url),
            'is_watch_list' => $this->is_watch_list ?? false,
            'subtitle_info' => $this->enable_subtitle == 1 ? SubtitleResource::collection($this->subtitles) : null,
            'is_likes' => $this->is_likes ?? false,
            'your_review' => $this->your_review ?? null,
            'total_review' => $this->total_review ?? 0,
            'genres' => GenresResource::collection($genre_data),
            // 'plans' => PlanResource::collection($plans),
            'reviews' => ReviewResource::collection($this->reviews ?? collect()),
            'three_reviews' => ReviewResource::collection($this->reviews ?? collect()->take(3)),
            'video_links' => $this->entertainmentStreamContentMappings ?? null,
            'casts' => CastCrewListResource::collection($casts),
            'directors' => CastCrewListResource::collection($directors),
            // 'more_items' => MoviesResource::collection($more_items),
            'status' => $this->status,
            'download_id' => !empty($download) ? $download->id: null,
            'is_device_supported' => $deviceTypeResponse['isDeviceSupported'],
            'poster_tv_image' => setBaseUrlWithFileName($this->poster_tv_url),
            'price' => (float)$this->price,
            'discounted_price' => round((float)$this->price - ($this->price * ($this->discount / 100)), 2),
            'purchase_type' => $this->purchase_type,
            'access_duration' => $this->access_duration,
            'discount'=> (float)$this->discount,
            'available_for' => $this->available_for,
        ];
    }
}
