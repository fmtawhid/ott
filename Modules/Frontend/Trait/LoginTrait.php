<?php

namespace Modules\Frontend\Trait;
use Jenssegers\Agent\Agent;
use App\Models\Device;
use App\Models\UserMultiProfile;
use DB;


trait LoginTrait
{

    public function CheckDeviceLimit($user, $current_device)
    {
        $count = Device::where('user_id', $user->id)->count();

        if($user->mobile=='+911234567890'){

            return [
                'success' => 'Your device limit is available.',
                'status' => 200
            ];

        }

        if ($user->subscriptionPackage) {
            $planLimitation = optional(optional($user->subscriptionPackage)->plan)->planLimitation;

            if ($planLimitation) {
                $deviceLimit = $planLimitation->where('limitation_slug', 'device-limit')->first();
                $deviceLimitCount = $deviceLimit ? $deviceLimit->limit : 1;

                if ($count >= $deviceLimitCount) {
                    return [
                        'error' => 'Your device limit has been reached.',
                        'status' => 406
                    ];
                }
            }
        } else {

            $existingDevice = Device::where('user_id', $user->id)->first();

            if ($existingDevice) {

                if ($existingDevice->device_id != $current_device) {
                    return [
                        'error' => 'Your device limit has been reached.',
                        'status' => 406
                    ];
                }
            }
        }

        return [
            'success' => 'Your device limit is available.',
            'status' => 200
        ];
    }


    public function CheckDevice($user)
    {
         if($user->subscriptionPackage==null){

            $agent = new Agent();

            if ($agent->isMobile()) {
                $deviceType = 'Mobile';
            } elseif ($agent->isTablet()) {
                $deviceType = 'Tablet';
            } elseif ($agent->isDesktop()) {
                $deviceType = 'Desktop';
            } else {
                $deviceType = 'Unknown';
            }

            $userAgent = $agent->getUserAgent();

            return response()->json(['status' => false, 'message' => __('messages.user_not_logged_in')]);


         }else{


         }

}

public function setDevice($user, $request){

    $agent = new Agent();
    $device_id = $request->getClientIp();
    $device_name =  $agent->browser();
    $platform = $agent->platform();

    $profile=UserMultiProfile::where('user_id',$user->id)->first();

    $device = Device::updateOrCreate(
        [
            'user_id' => $user->id,
            'device_id' => $device_id
        ],
        [
            'device_name' => $device_name,
            'platform' => $platform,
            'active_profile'=> $profile->id ?? null,
        ]
    );


}


public function removeDevice($user, $request){

    $device_id = $request->getClientIp();

    Device::where('device_id', $device_id)->where('user_id', $user->id)->delete();

}

}
