<?php

namespace Modules\Video\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoDownloadMapping extends Model
{
    use HasFactory;

    protected $table = 'video_download_mappings';
    // protected $fillable = ['video_id'];
    protected $fillable = [
     
        'video_id',
        'type',
        'quality', 
        'url',
      
    ];

    // public function video()
    // {
    //     return $this->belongsTo(Video::class, 'video_id');
    // }
}
