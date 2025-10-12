<?php

namespace Modules\Entertainment\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntertainmentView extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['entertainment_id', 'user_id' ,'profile_id'];


    public function entertainment()
    {
        return $this->belongsTo(Entertainment::class, 'entertainment_id');
    }

}
