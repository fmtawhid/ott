<?php

namespace Modules\Video\Models;

use App\Models\BaseModel;
use App\Models\Scopes\VideoScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Subscriptions\Models\Plan;
use Modules\Entertainment\Models\Subtitle;

class Video extends BaseModel
{

    use SoftDeletes;

    protected $table = 'videos';
    protected $fillable = [
        'name',
        'type',
        'description',
        'poster_url',
        'short_desc',
        'trailer_url_type',
        'trailer_url',
        'access',
        'plan_id',
        'status',
        'duration',
        'release_date',
        'is_restricted',
        'video_upload_type',
        'video_url_input',
        'download_status',
        'enable_quality',
        'download_type',
        'download_url',
        'enable_download_quality',
        'poster_tv_url',
        'price',
        'purchase_type',
        'access_duration',
        'discount',
        'available_for',
        'enable_subtitle',
        'subtitle_file',
        'subtitle_language',
        'subtitle_file_exists',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'seo_image',
        'google_site_verification',
        'canonical_url',
        'short_description'
    ];

    //  protected $appends = ['poster_url'];

    //  public function getPosterUrlAttribute()
    //  {
    //      $media = $this->getFirstMediaUrl('poster_url');
    //      return $media ? $media : 'https://dummyimage.com/600x300/cfcfcf/000000.png';
    //  }

    public function getBaseUrlAttribute($value)
    {
        return !empty($value) ? setBaseUrlWithFileNameV2() : NULL;
    }


     protected static function boot()
     {
         parent::boot();

         static::deleting(function ($video) {

             if ($video->isForceDeleting()) {

                $video->VideoStreamContentMappings()->withTrashed()->each(function ($mapping) {
                    $mapping->forceDelete();
                });

             } else {

                 $video->VideoStreamContentMappings()->delete();
             }

         });

         static::restoring(function ($video) {

           $video->VideoStreamContentMappings()->withTrashed()->restore();

         });
     }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
      //  static::addGlobalScope(new VideoScope);
    }

    public function VideoStreamContentMappings()
    {
        return $this->hasMany(VideoStreamContentMapping::class,'video_id','id');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function Watchlist()
    {
        return $this->hasMany(Watchlist::class,'entertainment_id','id','type');
    }
    public function video()
    {
        return $this->hasOne(\Modules\Video\Models\Video::class, 'id', 'entertainment_id');
    }

    public function entertainmentReviews()
    {
        return $this->hasMany(Review::class,'entertainment_id','id');
    }

    public function entertainmentLike()
    {
        return $this->hasMany(Like::class,'entertainment_id','id');
    }

    public function videoDownloadMappings()
    {
        return $this->hasMany(VideoDownloadMapping::class,'video_id','id');
    }


    public function subtitles()
    {
        return $this->hasMany(Subtitle::class, 'entertainment_id', 'id')->where('type', 'video');
    }


    //  w.id as is_watch_list,
    public static function get_popular_videos($videoIdsArray)
    {
        $builder = Video::selectRaw('videos.*,plan.level as plan_level,videos.poster_url as base_url')
            ->leftJoin('plan','plan.id','=','videos.plan_id');

            isset(request()->is_restricted) && $builder = $builder->where('is_restricted', request()->is_restricted);
        (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
            $builder = $builder->where('is_restricted',0);

        $builder = $builder->whereIn('videos.id', $videoIdsArray)
            ->where('videos.status', 1)
            ->get();

        return $builder;
    }

}
