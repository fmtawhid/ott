<?php

namespace Modules\Entertainment\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntertainmentDownload extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['entertainment_id', 'user_id', 'entertainment_type', 'is_download', 'type', 'quality', 'url','device_id'];


}
