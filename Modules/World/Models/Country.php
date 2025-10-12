<?php

namespace Modules\World\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'countries';
    protected $fillable=['name', 'status'];
    const CUSTOM_FIELD_MODEL = 'Modules\World\Models\Country';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

    protected static function newFactory()
    {
        return \Modules\World\database\factories\WorldFactory::new();
    }
}
