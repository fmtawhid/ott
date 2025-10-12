<?php

namespace Modules\Coupon\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Coupon\Database\factories\UserCouponRedeemFactory;

class UserCouponRedeem extends Model
{
    use HasFactory;
    protected $table = 'user_coupon_redeem';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'coupon_code', 'discount', 'coupon_id', 'booking_id'];
    
    protected static function newFactory(): UserCouponRedeemFactory
    {
        //return UserCouponRedeemFactory::new();
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'code');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
