<?php

namespace Modules\Episode\Models;

use App\Models\BaseModel;

class EpisodeDownloadMapping extends BaseModel
{

    protected $table = 'episode_download_mapping';

    protected $fillable = [

        'episode_id',
        'type',
        'quality',
        'url',
        'device_id'

    ];
}
