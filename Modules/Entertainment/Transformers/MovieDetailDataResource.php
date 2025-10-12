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
use Modules\Entertainment\Transformers\CommanResource;
use Modules\Entertainment\Models\EntertainmentDownload;




class MovieDetailDataResource  extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {

        $header = request()->headers->all();
        $device_type = !empty($header['device-type'])? $header['device-type'][0] : []; //for tv
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


        $genres = $this->entertainmentGenerMappings;

        $genre_ids = $genres->pluck('genre_id')->toArray();
        $entertaintment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)->pluck('entertainment_id')->toArray();
        $more_items = Entertainment::whereIn('id', $entertaintment_ids)->where('type','movie')->where('status',1)->limit(5)->get()->except($this->id);

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
        $getDeviceTypeData = Subscription::checkPlanSupportDevice($request->user_id,$device_type);
        $deviceTypeResponse = json_decode($getDeviceTypeData->getContent(), true); // Decode to associative array
        return [
            'id' => $this->id,
            'enable_quality' => $this->enable_quality,
            'is_download' => $this->is_download ?? false,
            'download_status' => $this->download_status,
            'download_type' => $this->download_type,
            'download_url' => $this->download_url,
            'enable_download_quality' => $this->enable_download_quality,
            'download_quality' => $downloadMappings,
            'is_watch_list' => $this->is_watch_list ?? false,
            'is_likes' => $this->is_likes ?? false,
            'your_review' => $this->your_review ?? null,
            'total_review' => $this->total_review ?? 0,
            'reviews' => ReviewResource::collection($this->reviews),
            'subtitle_info' => $this->enable_subtitle == 1 ? SubtitleResource::collection($this->subtitles) : null,
            'three_reviews' => ReviewResource::collection($this->reviews->take(3)),
            'video_links' => $this->entertainmentStreamContentMappings ?? null,
            'casts' => CastCrewListResource::collection($casts),
            'directors' => CastCrewListResource::collection($directors),
            'more_items' => CommanResource::collection($more_items),
            'status' => $this->status,
            'download_id' => !empty($download) ? $download->id: null,
            'is_device_supported' => $deviceTypeResponse['isDeviceSupported']
        ];
    }
}
