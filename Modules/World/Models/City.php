<?php

namespace Modules\World\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cities';
    protected $fillable=['name', 'status', 'state_id'];
    const CUSTOM_FIELD_MODEL = 'Modules\World\Models\City';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

    protected static function newFactory()
    {
        return \Modules\World\database\factories\WorldFactory::new();
    }
    public function city()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
