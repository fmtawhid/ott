<?php

namespace Modules\Coupon\Models;

use App\Models\BaseModel;
use Modules\Subscriptions\Models\Plan;
use Modules\Coupon\Models\CouponSubscriptionPlan;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupon\Database\factories\CouponFactory;

class Coupon extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['code', 'discount', 'discount_type','start_date', 'expire_date', 'status', 'description'];
    
    protected static function newFactory(): CouponFactory
    {
        //return CouponFactory::new();
    }
    public function subscriptionPlans()
    {
        return $this->belongsToMany(Plan::class, 'coupon_subscription_plan', 'coupon_id', 'subscription_plan_id');
    }
    public function userRedeems()
    {
        return $this->hasManyThrough(User::class, UserCouponRedeem::class, 'coupon_id', 'id', 'id', 'user_id');
    }
    public function CouponPlanMappings()
    {
        return $this->hasMany(CouponSubscriptionPlan::class, 'coupon_id', 'id');
    }
}
