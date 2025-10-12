<?php

namespace Modules\Entertainment\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class EntertainmentStreamContentMapping extends BaseModel
{
    use SoftDeletes;


    protected $table = 'entertainment_stream_content_mapping';

    protected $fillable = [
     
        'entertainment_id',
        'quality',
        'type',
        'url',
      
    ];
    
  
}
