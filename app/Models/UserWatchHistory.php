<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWatchHistory extends Model
{
    use HasFactory;
    protected $table = 'user_watch_histories';

    protected $fillable = [
        'user_id',
        'profile_id',
        'entertainment_id',
        'entertainment_type'
    ];
}
