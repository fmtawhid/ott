<?php

namespace Modules\World\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class World extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'worlds';
    protected $fillable=['name'];
    const CUSTOM_FIELD_MODEL = 'Modules\World\Models\World';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */


    protected $appends = ['feature_image'];

    protected function getFeatureImageAttribute()
    {
        $media = $this->getFirstMediaUrl('feature_image');
        return isset($media) && ! empty($media) ? $media : 'https://dummyimage.com/600x300/cfcfcf/000000.png';
    }
    protected static function newFactory()
    {
        return \Modules\World\database\factories\WorldFactory::new();
    }
}
