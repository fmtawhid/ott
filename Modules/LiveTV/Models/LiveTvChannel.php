<?php

namespace Modules\LiveTV\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LiveTV\Models\TvChannelStreamContentMapping;
use Modules\Subscriptions\Models\Plan;

class LiveTvChannel extends BaseModel
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'live_tv_channel';
    protected $fillable = [
        'name','category_id','poster_url','thumb_url','access','plan_id','description','status','poster_tv_url'
    ];
    // protected $appends = ['poster_url'];

    public function getBaseUrlAttribute($value)
    {
        return !empty($value) ? setBaseUrlWithFileNameV2() : NULL;
    }

    public function TvChannelStreamContentMappings()
    {
        return $this->hasOne(TvChannelStreamContentMapping::class,'tv_channel_id','id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function () {

        });

        static::restoring(function () {

        });
    }

    public function TvCategory()
    {
        return $this->hasOne(LiveTvCategory::class,'id','category_id');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    public static function get_top_channel($channelIdsArray)
    {
        return LiveTvChannel::selectRaw('live_tv_channel.id,live_tv_channel.id,
        live_tv_channel.name,live_tv_channel.plan_id,plan.level as plan_level,live_tv_channel.description,live_tv_channel.status,live_tv_channel.access,ltc.name as category,ltscm.stream_type,ltscm.embedded,ltscm.server_url,ltscm.server_url1,poster_url as poster_url,poster_tv_url as poster_tv_url,poster_url as base_url
    ')
        ->join('live_tv_stream_content_mapping as ltscm','ltscm.tv_channel_id','=','live_tv_channel.id')
        ->leftJoin('plan','plan.id','=','live_tv_channel.plan_id')
        ->leftJoin('live_tv_category as ltc','ltc.id','=','live_tv_channel.category_id')
        ->whereIn('live_tv_channel.id', $channelIdsArray)
        ->where('live_tv_channel.status', 1)
        ->get();
    }

    public static function get_channel()
    {
        return LiveTvChannel::selectRaw('live_tv_channel.id,live_tv_channel.id,live_tv_channel.name,live_tv_channel.plan_id,plan.level as plan_level,live_tv_channel.description,live_tv_channel.status,live_tv_channel.access,ltc.name as category,ltscm.stream_type,ltscm.embedded,ltscm.server_url,ltscm.server_url1,poster_url as poster_url,poster_tv_url as poster_tv_url,poster_url as base_url')
        ->join('live_tv_stream_content_mapping as ltscm','ltscm.tv_channel_id','=','live_tv_channel.id')
        ->leftJoin('plan','plan.id','=','live_tv_channel.plan_id')
        ->leftJoin('live_tv_category as ltc','ltc.id','=','live_tv_channel.category_id')
        ->where('live_tv_channel.status',1)
        ->orderBy('live_tv_channel.updated_at', 'desc')
        ->take(6)
        ->get();
    }

    public static function get_tvChannels_catgory_wise($category)
    {
        return LiveTvChannel::selectRaw('live_tv_channel.id,live_tv_channel.id,live_tv_channel.name,live_tv_channel.plan_id,plan.level as plan_level,live_tv_channel.description,live_tv_channel.status,live_tv_channel.access,ltc.name as category,ltscm.stream_type,ltscm.embedded,ltscm.server_url,ltscm.server_url1,poster_url as poster_url,poster_tv_url as poster_tv_url,poster_url as base_url')
        ->join('live_tv_stream_content_mapping as ltscm','ltscm.tv_channel_id','=','live_tv_channel.id')
        ->leftJoin('plan','plan.id','=','live_tv_channel.plan_id')
        ->leftJoin('live_tv_category as ltc','ltc.id','=','live_tv_channel.category_id')
        ->where('live_tv_channel.category_id',$category)
        ->where('live_tv_channel.status',1)
        ->orderBy('live_tv_channel.updated_at', 'desc')
        ->get();
    }
}
