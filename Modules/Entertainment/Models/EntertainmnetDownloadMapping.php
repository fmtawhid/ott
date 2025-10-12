<?php

namespace Modules\Entertainment\Models;

use App\Models\BaseModel;

class EntertainmnetDownloadMapping extends BaseModel
{

    protected $table = 'entertainment_download_mapping';

    protected $fillable = [
     
        'entertainment_id',
        'type',
        'quality', 
        'url',
      
    ];
}
