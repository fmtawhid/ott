<?php

namespace Modules\Banner\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;


class SliderResourceV2 extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        // $this->userId = $userId;
    }

    public function toArray($request): array
    {
        $data = null;

        $genresData = Cache::get('genres');

        switch ($this->type) {
            case 'movie':
            case 'tvshow':
                if($this->type === 'movie')
                {
                    $data =  self::get_movies($this,$genresData);
                }else{
                    $data =  self::get_Tvshow($this,$genresData);
                }
                break;

            case 'livetv':
                $data = self::get_liveTv($this);
                break;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'poster_url' => setBaseUrlWithFileName($this->poster_url),
            'file_url' => setBaseUrlWithFileName($this->file_url),
            'type' => $this->type,
            'data' => $data,
        ];
    }

    public static function get_Tvshow($movies,$genresData)
    {
        $genres = [];
        $genre_id = (!empty($movies->genres)) ? explode(",",$movies->genres) : NULL;

        foreach($genre_id as $k=>$v)
        {
             isset($genresData[$v]) && $genres[] = $genresData[$v];
        }

        return [
            'id' => $movies->e_id,
            'name' => $movies->name,
            'description' => strip_tags($movies->description),
            'trailer_url_type' => $movies->trailer_url_type,
            'type' => $movies->type,
            'trailer_url' => $movies->trailer_url_type=='Local' ? setBaseUrlWithFileName($movies->trailer_url) : $movies->trailer_url,
            'movie_access' => $movies->movie_access,
            'plan_id' => $movies->plan_id,
            'plan_level' => $movies->plan->level ?? 0,
            'language' => $movies->language,
            'imdb_rating' => $movies->IMDb_rating,
            'content_rating' => $movies->content_rating,
            'duration' => $movies->duration,
            'release_date' => $movies->release_date,
            'is_restricted' => $movies->is_restricted,
            'video_upload_type' => $movies->video_upload_type,
            'video_url_input' => $movies->video_upload_type=='Local' ? setBaseUrlWithFileName($movies->video_url_input) : $movies->video_url_input,
            'download_status' => $movies->download_status,
            'enable_quality' => $movies->enable_quality,
            'download_url' => $movies->download_url,
            'poster_image' =>  setBaseUrlWithFileName($movies->poster_url),
            'thumbnail_image' => setBaseUrlWithFileName($movies->thumbnail_url),
            'is_watch_list' => $movies->is_watch_list ?? false,
            'genres' => $genres,
            // 'genres' => GenresResource::collection($movies->genres),
            // 'plans' => PlanResource::collection($plans),
            'status' => $movies->status,
            // 'created_by' => $this->created_by,
            // 'updated_by' => $this->updated_by,
            // 'deleted_by' => $this->deleted_by,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            // 'deleted_at' => $this->deleted_at,
        ];
    }

    public static function get_movies($movies,$genresData)
    {
        $genres = [];
        $genre_id = (!empty($movies->genres)) ? explode(",",$movies->genres) : NULL;

        foreach($genre_id as $k=>$v)
        {
             isset($genresData[$v]) && $genres[] = $genresData[$v];
        }
        return [
            'id' => $movies->e_id,
            'name' => $movies->name,
            'description' => strip_tags($movies->description),
            'trailer_url_type' => $movies->trailer_url_type,
            'type' => $movies->type,
            'trailer_url' => $movies->trailer_url_type=='Local' ? setBaseUrlWithFileName($movies->trailer_url) : $movies->trailer_url,
            'movie_access' => $movies->movie_access,
            'plan_id' => $movies->plan_id,
            'plan_level' => $movies->plan_level ?? 0,
            'language' => $movies->language,
            'imdb_rating' => $movies->IMDb_rating,
            'content_rating' => $movies->content_rating,
            'duration' => $movies->duration,
            'release_date' => $movies->release_date,
            'is_restricted' => $movies->is_restricted,
            'video_upload_type' => $movies->video_upload_type,
            'video_url_input' => $movies->video_upload_type=='Local' ? setBaseUrlWithFileName($movies->video_url_input) : $movies->video_url_input,
            'download_status' => $movies->download_status,
            'enable_quality' => $movies->enable_quality,
            'download_url' => $movies->download_url,
            'poster_image' => setBaseUrlWithFileName($movies->poster_url ?? null),
            'thumbnail_image' =>setBaseUrlWithFileName($movies->thumbnail_url ?? null),
            'is_watch_list' => ($movies->is_watch_list == 1) ? true : false,
            'genres' => $genres,
            'status' => $movies->status,
        ];
    }

    public static function get_liveTv($d)
    {
        return [
            'id' => $d->live_tv_id,
            'name' => $d->live_tv_name,
            'plan_id' => $d->live_tv_plan_id,
            'plan_level' => $d->live_tv_plan_level ?? 0,
            'description' => strip_tags($d->live_tv_description),
            'poster_image' => setBaseUrlWithFileName($d->live_tv_poster_url),
            'category' => $d->live_tv_category,
            'stream_type' => $d->live_tv_stream_type,
            'embedded' => $d->live_tv_embedded,
            'server_url' => $d->live_tv_server_url,
            'server_url1' => $d->live_tv_server_url1,
            // 'plans' => PlanResource::collection($plans),
            'status' => $d->status,
            'access'=>$d->access,
        ];
    }
}
