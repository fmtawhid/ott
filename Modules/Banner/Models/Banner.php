<?php

namespace Modules\Banner\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Entertainment\Models\Entertainment;

class Banner extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'banners';
    protected $fillable = ['title', 'file_url','poster_url','type', 'type_id','type_name', 'status', 'created_by','banner_for','poster_tv_url'];
    const CUSTOM_FIELD_MODEL = 'Modules\Banner\Models\Banner';

    public static function get_sliderList($type=null)
    {
        $query= Banner::selectRaw('banners.id,banners.banner_for,banners.title,banners.poster_url,banners.file_url,banners.type,e.id as e_id,e.name,e.type,e.plan_id,plan.level as plan_level,e.description,e.trailer_url_type,e.is_restricted,e.language,e.imdb_rating,e.content_rating,e.duration,e.video_upload_type,GROUP_CONCAT(egm.genre_id) as genres,e.release_date,e.trailer_url,e.video_url_input,e.poster_url as poster_image,e.trailer_url as base_url,e.movie_access,e.download_status,e.enable_quality,e.download_url,e.status,(CASE WHEN (select id from  watchlists where watchlists.entertainment_id = e.id and user_id = '.loggedUserId().' LIMIT 1) THEN 1 ELSE 0 END) AS is_watch_list,live_tv_channel.id as live_tv_id,live_tv_channel.name as live_tv_name,live_tv_channel.plan_id as live_tv_plan_id,ltv_plan.level as live_tv_plan_level,live_tv_channel.description as live_tv_description,live_tv_channel.status as live_tv_status,live_tv_channel.access as live_tv_access,ltc.name as live_tv_category,ltscm.stream_type as live_tv_stream_type,ltscm.embedded as live_tv_embedded,ltscm.server_url as live_tv_server_url,ltscm.server_url1 as live_tv_server_url1')
            ->leftJoin('entertainments as e', function($q){

                $q->on('e.id','=','banners.type_id');
                isset(request()->is_restricted) && $q->where('is_restricted', request()->is_restricted);
                (!empty(getCurrentProfileSession('is_child_profile')) && getCurrentProfileSession('is_child_profile') != 0) &&
                    $q->where('is_restricted',0);
            })
            ->join('entertainment_gener_mapping as egm','egm.entertainment_id','=','e.id')
            ->leftJoin('plan','plan.id','=','e.plan_id')
            ->leftJoin('live_tv_channel','live_tv_channel.id','=','banners.type_id')
            ->leftJoin('live_tv_stream_content_mapping as ltscm','ltscm.tv_channel_id','=','live_tv_channel.id')
            ->leftJoin('plan as ltv_plan','ltv_plan.id','=','live_tv_channel.plan_id')
            ->leftJoin('live_tv_category as ltc','ltc.id','=','live_tv_channel.category_id')
            ->where('banners.status', 1)
            ->groupBy('e.id');

            if(!empty($type)){
                $query->where('banners.banner_for', $type );

            }

            return $query->get();
    }

    public function entertainment()
    {
        return $this->belongsTo(Entertainment::class,'entertainment_id')->with('entertainmentGenerMappings');
    }
}
