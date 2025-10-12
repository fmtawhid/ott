<?php

namespace Modules\Coupon\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupon\Database\factories\CouponSubscriptionPlanFactory;

class CouponSubscriptionPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [ 'coupon_id', 'subscription_plan_id'];
    
    protected static function newFactory(): CouponSubscriptionPlanFactory
    {
        //return CouponSubscriptionPlanFactory::new();
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(Plan::class, 'subscription_plan_id');
    }
}
