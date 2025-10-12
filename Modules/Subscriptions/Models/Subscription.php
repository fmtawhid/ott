<?php

namespace Modules\Subscriptions\Models;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Subscriptions\Models\SubscriptionTransactions;
use Jenssegers\Agent\Agent;
use Illuminate\Database\Eloquent\SoftDeletes;


class Subscription extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = 
        [
        'plan_id',
        'user_id',
        'device_id',
        'start_date',
        'end_date',
        'status',
        'is_manual',
        'amount',
        'discount_percentage',
        'tax_amount',
        'total_amount',
        'name',
        'identifier',
        'type',
        'duration',
        'level',
        'plan_type',
        'payment_id',
        'coupon_discount',
    ];
    
    
    
      protected $casts = [
        'user_id' => 'integer',
        'plan_id' => 'integer',
        'total_amount' => 'integer',
        'amount' => 'integer',
        'discount_percentage' => 'integer',
        'tax_amount' => 'integer',
        'tax_amount' => 'integer',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subscription_transaction()
    {
        return $this->hasOne(SubscriptionTransactions::class, 'subscriptions_id', 'id');
    }

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }

    protected static function newFactory()
    {
        return \Modules\Subscriptions\Database\factories\SubscriptionFactory::new();
    }
    public static function checkPlanSupportDevice($user_id,$device_type = []){
        $user = User::where('id',$user_id)->first();
        $currentSubscription = Subscription::where('user_id', $user_id)
        ->where('status', 'active')
        ->orderBY('id','desc')
        ->first();
        $agent = new Agent();

        // Determine device type
        if ($agent->isMobile()) {
            $deviceType = 'mobile';
        } elseif ($agent->isTablet()) {
            $deviceType = 'tablet';
        } elseif ($agent->isDesktop()) {
            $deviceType = 'desktop';
        } else {
            $deviceType = 'unknown'; // For any unsupported device types
        }



        // If there's no active subscription, only allow mobile
        if (!$currentSubscription) {

            return response()->json(['isDeviceSupported' => $deviceType === 'mobile', 'device_name' => $deviceType]);
        }

        if ($user && $user->subscriptionPackage && $user->subscriptionPackage->plan) {
            $planLimitation = $user->subscriptionPackage->plan->planLimitation;
        } else {
            $planLimitation = [];
        }

        if(!empty($planLimitation )){

            $deviceLimits = $planLimitation->where('limitation_slug', 'supported-device-type')->first();

            // Decode the device limits from JSON
            $deviceLimitsArray = $deviceLimits ? json_decode($deviceLimits->limit, true) : [];
          // Check if the current device type is supported
            if($device_type == 'AndroidTV'){
                if (isset($deviceLimitsArray['tv']) && $deviceLimitsArray['tv'] == 1) {
                    return response()->json(['isDeviceSupported' => true, 'device_name' => 'AndroidTV']);
                }else{
                    return response()->json(['isDeviceSupported' => false, 'device_name' => 'AndroidTV']);
                }
            }
            if (isset($deviceLimitsArray[$deviceType]) && $deviceLimitsArray[$deviceType] == 1) {
                return response()->json(['isDeviceSupported' => true, 'device_name' => $deviceType]);
            }
            // Check if the device is desktop and if laptop is allowed
            if ($deviceType === 'desktop' && isset($deviceLimitsArray['laptop']) && $deviceLimitsArray['laptop'] == 1) {
                return response()->json(['isDeviceSupported' => true, 'device_name' => 'laptop']);
            }

        }
        return response()->json(['isDeviceSupported' => false, 'device_name' => $deviceType]);
    }
}
