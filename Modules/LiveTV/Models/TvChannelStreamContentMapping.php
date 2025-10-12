<?php

namespace Modules\LiveTV\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LiveTV\Database\factories\TvChannelStreamContentMappingFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvChannelStreamContentMapping extends BaseModel
{
    use SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'live_tv_stream_content_mapping';
    protected $fillable = [
        'tv_channel_id',
        'type',
        'stream_type',
        'embedded',
        'server_url',
        'server_url1',
    ];
    
    protected static function newFactory(): TvChannelStreamContentMappingFactory
    {
        //return TvChannelStreamContentMappingFactory::new();
    }
}
