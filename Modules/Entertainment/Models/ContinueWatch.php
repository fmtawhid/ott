<?php

namespace Modules\Entertainment\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Episode\Models\Episode;
use Modules\Video\Models\Video;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class ContinueWatch extends BaseModel
{
    use SoftDeletes;

    protected $table = 'continue_watch';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['entertainment_id', 'user_id', 'entertainment_type', 'watched_time', 'total_watched_time','profile_id','episode_id'];


    public function entertainment()
    {
        $result = $this->hasOne(Entertainment::class, 'id', 'entertainment_id')->with('entertainmentGenerMappings','plan');
        isset(request()->is_restricted) && $result = $result->where('is_restricted', request()->is_restricted);
        return $result;
    }

    public function episode()
    {
        $result = $this->hasOne(Episode::class,'id','entertainment_id')->with('plan');
        isset(request()->is_restricted) && $result = $result->where('is_restricted', request()->is_restricted);
        return $result;
    }

    public function video()
    {
        $result = $this->hasOne(Video::class,'id','entertainment_id')->with('plan');
        isset(request()->is_restricted) && $result = $result->where('is_restricted', request()->is_restricted);
        return $result;
    }

    public function entertainmentNew()
    {
        return $this->hasOne(Entertainment::class, 'id', 'entertainment_id');
    }

    public function episodeNew()
    {
        return $this->hasOne(Episode::class,'id','entertainment_id');
    }

    public function videoNew()
    {
        return $this->hasOne(Video::class,'id','entertainment_id');
    }
}
