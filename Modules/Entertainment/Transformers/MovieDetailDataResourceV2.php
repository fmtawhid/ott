<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entertainment\Transformers\ReviewResource;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Entertainment\Models\EntertainmentGenerMapping;
use Modules\Entertainment\Models\Entertainment;
use Modules\Subscriptions\Models\Subscription;
use Modules\Entertainment\Transformers\CommanResource;


class MovieDetailDataResourceV2  extends JsonResource
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
            if($mapping->talentprofile)
            {
                if ($mapping->talentprofile->type === 'actor') {
                    $casts[] = $mapping->talentprofile;
                } elseif ($mapping->talentprofile->type === 'director') {
                    $directors[] = $mapping->talentprofile;
                }
            }
        }

        // $genres = $this->entertainmentGenerMappings;
        // $genre_ids = $genres->pluck('genre_id')->toArray();
        $genre_ids =  !empty($this->genre_ids) ? explode(",",$this->genre_ids) : NULL;

        $entertaintment_ids = EntertainmentGenerMapping::whereIn('genre_id', $genre_ids)->pluck('entertainment_id')->toArray();
        $more_items = Entertainment::whereIn('id', $entertaintment_ids)
        ->where('type','movie');
        isset(request()->is_restricted) && $more_items = $more_items->where('is_restricted', request()->is_restricted);
            (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                $more_items = $more_items->where('is_restricted',0);

        $more_items = $more_items->where('status',1)
            ->limit(5)
            ->get()->except($this->id);

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
            'your_review' => self::getReview($this) ?? null,
            'total_review' => $this->total_review ?? 0,
            'reviews' => ReviewResource::collection($this->reviews),
            'three_reviews' => ReviewResource::collection($this->reviews->take(3)),
            'video_links' => $this->entertainmentStreamContentMappings ?? null,
            'subtitle_info' => $this->enable_subtitle == 1 ? SubtitleResource::collection($this->subtitles) : null,
            'casts' => CastCrewListResource::collection($casts),
            'directors' => CastCrewListResource::collection($directors),
            'more_items' => CommanResource::collection($more_items),
            'status' => $this->status,
            'download_id' => $this->is_download,
            'is_device_supported' => $deviceTypeResponse['isDeviceSupported'],
            'price' => (float)$this->price,
            'discounted_price' => round((float)$this->price - ($this->price * ($this->discount / 100)), 2),
            'purchase_type' => $this->purchase_type,
            'access_duration' => $this->access_duration,
            'discount'=> (float)$this->discount,
            'available_for' => $this->available_for,
            'is_purchased' => Entertainment::isPurchased($this->id,'movie',$this->user_id),
        ];
      
    }

    public static function getReview($data)
    {
        $result = NULL;

        if(!empty($data['your_review']))
        {
            $result = [
                'id' => $data['your_review_id'],
                'entertainment_id' => $data['id'],
                'rating' => $data['your_review_rating'],
                'review' => $data['your_review'],
                'user_id' => $data['your_review_user_id'],
                'username' => optional($data['your_review_first_name'].' '.$data['your_review_last_name']) ?? default_user_name(),
                'profile_image' => setBaseUrlWithFileName($data['your_review_file_url']),
                'created_at' => $data['your_review_created_at'],
                'updated_at' => $data['your_review_updated_at']
            ];
        }

        return $result;
    }
}
