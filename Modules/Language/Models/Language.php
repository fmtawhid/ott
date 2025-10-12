<?php

namespace Modules\Language\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Language extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'languages';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Language\database\factories\LanguageFactory::new();
    }

    public static function getAllLang()
    {
        return Cache::rememberForever('lang.all', function () {
            return self::get();
        });
    }

    /**
     * Flush the cache.
     */
    public static function flushCache()
    {
        Cache::forget('lang.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }
}
