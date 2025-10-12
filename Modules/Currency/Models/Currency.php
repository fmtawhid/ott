<?php

namespace Modules\Currency\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'currencies';
     protected $fillable = [
        'currency_name', 'currency_symbol', 'currency_code', 'currency_position', 'no_of_decimal', 'thousand_separator', 'decimal_separator', 'is_primary',
    ];
    const CUSTOM_FIELD_MODEL = 'Modules\Currency\Models\Currency';

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
        return \Modules\Currency\database\factories\CurrencyFactory::new();
    }
        public static function format($value)
    {
        return '$' . number_format($value, 2); 
    }

}
