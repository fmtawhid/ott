<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'device_id', 'device_name', 'platform','active_profile'];

    protected $casts = [
        'user_id' => 'integer',
        // add other casts as needed
    ];

}
