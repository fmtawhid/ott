<?php

namespace Modules\FAQ\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'faqs';

    // Fillable attributes
    protected $fillable = ['question', 'answer', 'status']; // Ensure all relevant attributes are included

    const CUSTOM_FIELD_MODEL = 'Modules\FAQ\Models\FAQ';

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
        return \Modules\FAQ\database\factories\FAQFactory::new();
    }
}
