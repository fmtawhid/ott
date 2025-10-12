<?php

namespace Modules\Entertainment\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Video\Models\Video; 

class Watchlist extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['entertainment_id','user_id','type','profile_id'];
    
    public function entertainment()
    {
        return $this->hasOne(Entertainment::class, 'id', 'entertainment_id')->with('entertainmentGenerMappings','plan');
    }
    public function video()
    {
        return $this->belongsTo(Video::class, 'entertainment_id', 'id'); // Change to belongsTo since the watchlist belongs to a video
    }
}
