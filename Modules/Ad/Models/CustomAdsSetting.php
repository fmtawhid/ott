<?php

namespace Modules\Ad\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Ad\Database\factories\CustomAdsSettingFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomAdsSetting extends Model
{
    use HasFactory;
    use Softdeletes;
    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'custom_ads_setting';

    protected $fillable = [
        'name',
        'type',
        'url_type',
        'placement',
        'media',
        'redirect_url',
        'duration',
        'skip_enabled',
        'skip_after',
        'target_content_type',
        'target_categories',
        'max_views',
        // 'is_enable',
        'status',
        'start_date',
        'end_date',
    ];
    
    protected static function newFactory(): CustomAdsSettingFactory
    {
        //return CustomAdsSettingFactory::new();
    }
}
