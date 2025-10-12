<?php

namespace App\Models;

use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;

class Setting extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use HasHashedMediaTrait;

    protected $table = 'settings';

    /**
     * Add a settings value.
     *
     * @param  string  $type
     * @return bool
     */
    public static function add($key, $val, $type = 'string', $datatype = null)
    {
        $currentUser = auth()->user();
        if($datatype == 'bussiness' || $datatype == 'misc'){

            $existingRecord = self::where('name', $key)->where('datatype', $datatype)->first();

            if ($existingRecord) {
                return self::set($key, $val, $type,$currentUser,$datatype);
            }
            return self::create([
                'name' => $key,
                'val' => $val,
                'type' => $type,
                'datatype' => $datatype,
                'created_by' => $currentUser->id,
                'updated_by' => $currentUser->id
            ]);
        }else{
            if (self::has($key)) {
                return self::set($key, $val, $type,$currentUser,$datatype);
            }
        }


        return self::create(['name' => $key, 'val' => $val, 'type' => $type, 'datatype' => $datatype]);
    }

    /**
     * Get a settings value.
     *
     * @param  null  $default
     * @return bool|int|mixed
     */
    public static function get($key, $default = null,$datatype = null)
    {
        if (self::has($key)) {
            $datatype = self::getType($key);
            $userId = auth()->id();
            if($datatype == 'bussiness' || $datatype == 'misc'){
                    $setting = self::getAllSettings($userId,$datatype)->where('name', $key)->first();

                    return $setting ? self::castValue($setting->val, $setting->type) : self::getDefaultValue($key, $default);
            }

            $setting = self::getAllSettings($userId,$datatype)->where('name', $key)->first();

            return self::castValue($setting->val, $setting->type);
        }

        return self::getDefaultValue($key, $default);
    }

    /**
     * Set a value for setting.
     *
     * @param  string  $type
     * @return bool
     */
    public static function set($key, $val, $type = 'string',$currentUser,$datatype='')
    {
        $datatype = $datatype ? $datatype : null;
        $userId = $currentUser ? $currentUser->id : auth()->id();
        if($datatype == 'bussiness' || $datatype == 'misc'){

            $setting = self::getAllSettings($userId,$datatype)->where('name', $key)->first();

            if ($setting) {

                return $setting->update([
                    'name' => $key,
                    'val' => $val,
                    'type' => $type,
                    'datatype' => $datatype
                ]) ? $setting : false;
            }
        }else{
            if ($setting = self::getAllSettings($userId,$datatype)->where('name', $key)->first()) {
                return $setting->update([
                    'name' => $key,
                    'val' => $val,
                    'type' => $type,
                    'datatype' => $datatype
                ]) ? $setting : false;
            }
        }


        return self::add($key, $val, $type, $datatype = null);
    }

    /**
     * Remove a setting.
     *
     * @return bool
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists.
     *
     * @return bool
     */
    public static function has($key)
    {
        return (bool) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Get the validation rules for setting fields.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    public static function getSelectedValidationRules($value)
    {
        return self::getDefinedSettingFields()->whereIn('name', $value)->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Get the data type of a setting.
     *
     * @return mixed
     */
    public static function getDataType($field)
    {
        $type = self::getDefinedSettingFields()
            ->pluck('data', 'name')
            ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    public static function getType($field)
    {
        $datatype = self::getDefinedSettingFields()
            ->pluck('datatype', 'name')
            ->get($field);

        return is_null($datatype) ? null : $datatype;
    }

    /**
     * Get default value for a setting.
     *
     * @return mixed
     */
    public static function getDefaultValueForField($field)
    {
        return self::getDefinedSettingFields()
            ->pluck('value', 'name')
            ->get($field);
    }

    /**
     * Get default value from config if no value passed.
     *
     * @return mixed
     */
    private static function getDefaultValue($key, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key) : $default;
    }

    /**
     * Get all the settings fields from config.
     *
     * @return Collection
     */
    private static function getDefinedSettingFields()
    {
        return collect(config('setting_fields'))->pluck('elements')->flatten(1);
    }

    /**
     * caste value into respective type.
     *
     * @return bool|int
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }

    /**
     * Get all the settings.
     *
     * @return mixed
     */
    public static function getAllSettings($userId = null,$datatype = null)
    {
        if($datatype == 'bussiness' || $datatype == 'misc'){
            $userId = $userId ?: (auth()->check() ? auth()->id() : null);
            if ($userId !== null) {
                $userData = self::where('created_by', $userId)->select('id', 'name', 'val','datatype','created_by')->get();
                return $userData;
            }else{
                return collect();
            }
        }
        return Cache::rememberForever('settings.all', function () {
            return self::select('id', 'name', 'val','datatype')->get();
        });
    }

    /**
     * Flush the cache.
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
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
