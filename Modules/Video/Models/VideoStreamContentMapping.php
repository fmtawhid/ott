<?php

namespace Modules\Video\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class VideoStreamContentMapping extends BaseModel
{
     use SoftDeletes;

    protected $table = 'video_stream_content_mapping';
    protected $fillable=['video_id','type','quality','url'];
    
 
}
