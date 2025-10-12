<?php

namespace Modules\Entertainment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Entertainment\Database\factories\SubtitleFactory;
use Modules\Episode\Models\Episode;
use Modules\Video\Models\Video;
class Subtitle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'entertainment_id',
        'type',
        'language',
        'language_code',
        'subtitle_file',
        'is_default'
    ];
    
    // protected static function newFactory(): SubtitleFactory
    // {
    //     //return SubtitleFactory::new();
    // }
        public function entertainment()
    {
        return $this->belongsTo(Entertainment::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
