<?php

namespace Modules\Filemanager\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;

class Filemanager extends BaseModel implements HasMedia
{
    use HasFactory, SoftDeletes;

    protected $table = 'filemanagers';

    protected $guarded = [];

    protected $appends = ['file_url'];
    const CUSTOM_FIELD_MODEL = 'Modules\Filemanager\Models\Filemanager';

    protected function getFileUrlAttribute()
    {
        $media = $this->getFirstMediaUrl('file_url');

        return isset($media) && !empty($media) ? $media : default_file_url();
    }
}

