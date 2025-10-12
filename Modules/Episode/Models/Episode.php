<?php

namespace Modules\Episode\Models;

use App\Models\BaseModel;
use App\Models\Scopes\EpisodeScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Entertainment\Models\Entertainment;
use Modules\Season\Models\Season;
use Modules\Subscriptions\Models\Plan;
use Modules\Entertainment\Models\Subtitle;

class Episode extends BaseModel
{

    use SoftDeletes;

    protected $table = 'episodes';
    protected $fillable=[ 'name',
                          'entertainment_id',
                          'season_id',
                          'poster_url',
                          'trailer_url_type',
                          'trailer_url',
                          'access',
                          'plan_id',
                          'IMDb_rating',
                          'content_rating',
                          'duration',
                          'release_date',
                          'is_restricted',
                          'short_desc',
                          'description',
                          'enable_quality',
                          'video_upload_type',
                          'video_url_input',
                          'download_status',
                          'download_type',
                          'download_url',
                          'enable_download_quality',
                          'status',
                          'video_quality_url','tmdb_id','tmdb_season','episode_number','poster_tv_url','enable_subtitle',
                        'poster_tv_url',
                        'price',
                        'purchase_type',
                        'access_duration',
                        'discount',
                        'available_for',
                        'slug',
                        'meta_title',
                        'meta_keywords',
                        'meta_description',
                        'seo_image',
                        'google_site_verification',
                        'canonical_url',
                        'short_description',
                    ];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($episode) {

         if ($episode->isForceDeleting()) {

             $episode->EpisodeStreamContentMapping()->forceDelete();
             $episode->episodeDownloadMappings()->forceDelete();

         } else {

             $episode->EpisodeStreamContentMapping()->delete();
             $episode->episodeDownloadMappings()->delete();
         }

        });

        static::restoring(function ($episode) {

            $episode->EpisodeStreamContentMapping()->withTrashed()->restore();
            $episode->episodeDownloadMappings()->delete();

        });
    }

     /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
       // static::addGlobalScope(new EpisodeScope);
    }


    public function entertainmentdata()
    {
        return $this->belongsTo(Entertainment::class,'entertainment_id')->with('entertainmentGenerMappings');
    }


    public function seasondata()
    {
        return $this->belongsTo(Season::class,'season_id');
    }

    public function episodeDownloadMappings()
    {
        return $this->hasMany(EpisodeDownloadMapping::class, 'episode_id', 'id');
    }


    public function EpisodeStreamContentMapping()
    {
        return $this->hasMany(EpisodeStreamContentMapping::class,'episode_id','id');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class, 'entertainment_id', 'id')->where('type', 'episode');
    }

}
