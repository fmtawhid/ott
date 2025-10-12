<?php

namespace Modules\Season\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Entertainment\Models\Entertainment;
use Modules\Episode\Models\Episode;
use Modules\Subscriptions\Models\Plan;

class Season extends BaseModel
{

    use SoftDeletes;

    protected $table = 'seasons';

    protected $fillable = [
        'name',
        'tmdb_id',
        'season_index',
        'entertainment_id',
        'poster_url',
        'short_desc',
        'description',
        'trailer_url_type',
        'trailer_url',
        'access',
        'plan_id',
        'status',
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
        'short_description'
    ];


    public function entertainmentdata()
    {
        return $this->belongsTo(Entertainment::class,'entertainment_id');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class, 'season_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($season) {

            if ($season->isForceDeleting()) {

                $season->episodes()->forceDelete();

            } else {

                $season->episodes()->delete();
            }

        });

        static::restoring(function ($season) {

            $season->episodes()->withTrashed()->restore();

        });
    }



}
