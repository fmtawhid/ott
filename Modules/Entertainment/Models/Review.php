<?php

namespace Modules\Entertainment\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\BaseModel;
class Review extends BaseModel
{

    use SoftDeletes;

    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['entertainment_id', 'user_id', 'rating', 'review','updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function entertainment()
    {
        return $this->belongsTo(Entertainment::class, 'entertainment_id');
    }
}
