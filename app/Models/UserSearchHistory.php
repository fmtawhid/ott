<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Entertainment\Models\Entertainment;
use Modules\Episode\Models\Episode;
use Modules\Video\Models\Video;
use Modules\CastCrew\Models\CastCrew;


class UserSearchHistory extends Model
{
    use HasFactory;

    protected $table = 'user_search_histories';

    protected $fillable = [
        'user_id',
        'profile_id',
        'search_query',
        'search_id',
        'type'
    ];

    public function entertainment()
    {
        return $this->belongsTo(Entertainment::class, 'search_id');
    }


    public function episode()
    {
        return $this->belongsTo(Episode::class, 'search_id');
    }


    public function video()
    {
        return $this->belongsTo(Video::class, 'search_id');
    }


    public function castcrew()
    {
        return $this->belongsTo(CastCrew::class, 'search_id');
    }





}
