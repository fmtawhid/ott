<?php

namespace Modules\Episode\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class EpisodeStreamContentMapping extends BaseModel
{
    use SoftDeletes;

    protected $table = 'episode_stream_content_mapping';
   
    protected $fillable = ['episode_id','quality','type','url'];
    
   
}
