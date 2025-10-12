<?php

namespace Modules\Entertainment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Modules\Entertainment\Models\Entertainment;
use Modules\Entertainment\Models\Watchlist;

class CommanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        $genre_data = [];
        $genres = $this->entertainmentGenerMappings;

        if(!empty($genres)){

            foreach($genres as $genre) {

                $genre_data[] = [
                    'id' => $genre->id,
                    'name' => $genre->genre->name ?? null,
                ];
            }


        }


        $userId = auth()->id() ;
        if($userId) {
            $isInWatchList = WatchList::where('entertainment_id',$this->id)
            ->where('user_id', $userId)
            ->exists();
        }else{
            $isInWatchList = $this->is_watch_list ?? false;
        }
        // dd($this->id,auth()->user());
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'movie_access' => in_array($this->type, ['movie', 'tvshow']) ? $this->movie_access : $this->access,
            'plan_id' => $this->plan_id,
            'plan_level' => $this->plan->level ?? 0,
            'description' => strip_tags($this->description),
            'trailer_url_type' => $this->trailer_url_type,
            'genres' => $genre_data,
            'release_date' => $this->release_date,
            'release_year' => Carbon::parse($this->release_date)->year,
            'is_restricted' => $this->is_restricted,
            'language' => $this->language,
            'imdb_rating' => $this->IMDb_rating,
            'watched_time' => optional($this->continue_watch)->watched_time ?? null,
            'content_rating' => $this->content_rating,
            'duration' => $this->duration,
            'is_watch_list' => $isInWatchList ? true : false,
            'trailer_url' => $this->trailer_url_type=='Local' ? setBaseUrlWithFileName($this->trailer_url) : $this->trailer_url,
            'video_upload_type' => $this->video_upload_type,
            'video_url_input' => $this->video_upload_type=='Local' ? setBaseUrlWithFileName($this->video_url_input) : $this->video_url_input,
            'poster_image' => setBaseUrlWithFileName($this->poster_url),
            'thumbnail_image' => setBaseUrlWithFileName($this->thumbnail_url),
            'poster_tv_image' => setBaseUrlWithFileName($this->poster_tv_url),
            'price' => (float)$this->price,
            'discounted_price' => round((float)$this->price - ($this->price * ($this->discount / 100)), 2),
            'purchase_type' => $this->purchase_type,
            'access_duration' => $this->access_duration,
            'discount'=> (float)$this->discount,
            'available_for' => $this->available_for,
            'is_purchased' => Entertainment::isPurchased($this->id,$this->type,$this->user_id),
        ];
    }
}
