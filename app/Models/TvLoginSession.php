<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class TvLoginSession extends Model
{
    protected $table = 'tv_login_sessions';
    protected $fillable = ['session_id', 'user_id', 'confirmed_at', 'expires_at'];
    protected $casts = [
        'confirmed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function createSession(): self
    {
        return self::create([
            'session_id' => Str::uuid(),
            'expires_at' => now()->addMinutes(5),
        ]);
    }
}
