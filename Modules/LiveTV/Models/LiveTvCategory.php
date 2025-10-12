<?php

namespace Modules\LiveTV\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveTvCategory extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'live_tv_category';

    protected $fillable = [
        'name',
        'file_url',
        'description',
        'status',
    ];




    public function tvChannels()
    {
        return $this->hasMany(LiveTvChannel::class,'category_id')->where('status', 1)->with('TvChannelStreamContentMappings');
    }
}
