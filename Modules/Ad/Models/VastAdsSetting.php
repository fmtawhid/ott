<?php

namespace Modules\Ad\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Ad\Database\factories\VastAdsSettingFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VastAdsSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vast_ads_setting';
    
    protected $fillable = [
        'name',
        'type',
        'url',
        'duration',
        'target_type',
        'target_selection',
        'enable_skip',
        'skip_after',
        'frequency',
        'is_enable',
        'status',
        'start_date',
        'end_date',
    ];

    protected $hidden = [
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'enable_skip' => 'boolean',
        'is_enable' => 'boolean',
        'status' => 'boolean',
        // 'frequency' => 'integer',
    ];

    // Scope for active ads
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    // protected static function newFactory(): VastAdsSettingFactory
    // {
    //     //return VastAdsSettingFactory::new();
    // }
}
