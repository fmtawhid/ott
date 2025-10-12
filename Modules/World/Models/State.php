<?php

namespace Modules\World\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'states';
    protected $fillable=['name', 'status', 'country_id'];
    const CUSTOM_FIELD_MODEL = 'Modules\World\Models\State';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

    protected static function newFactory()
    {
        return \Modules\World\database\factories\WorldFactory::new();
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
