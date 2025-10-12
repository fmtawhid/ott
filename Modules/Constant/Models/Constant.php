<?php

namespace Modules\Constant\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Constant extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'constants';
    protected $fillable=['name','type','value','status']; 
    const CUSTOM_FIELD_MODEL = 'Modules\Constant\Models\Constant';

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
        return \Modules\Constant\database\factories\ConstantFactory::new();
    }
}
