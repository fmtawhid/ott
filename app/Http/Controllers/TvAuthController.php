<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TvLoginSession;
use App\Models\User;
use App\Models\Device;
use App\Models\UserMultiProfile;
use App\Http\Resources\LoginResource;
use Auth;

class TvAuthController extends Controller
{
    // public function linkTv(Request $request)
    // {
    //     $user = auth()->user(); // cleaner way to get the authenticated user

    //     // Update the user's temp_token
    //     $user->update([
    //         'temp_token' => $request->input('temp_token'),
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Temp token linked successfully.',
    //     ]);

    // }

    // TV App - Create session and return session_id
    public function initiateSession()
    {
        $session = TvLoginSession::createSession();

        return response()->json([
            'session_id' => $session->session_id,
            'expires_at' => now()->addMinutes(5)
        ]);
    }

    // Mobile App - Confirm session using user token
    public function confirmSession(Request $request)
    {
        // dd($request);
        $request->validate([
            'session_id' => 'required|uuid',
        ]);

        $session = TvLoginSession::where('session_id', $request->session_id)->where('expires_at', '>', now())->first();

        if (!$session) {
            return response()->json(['status' => false, 'message' => 'Session not found or expired.'], 404);
        }

        $session->update([
            'user_id' => auth()->id(),
            'confirmed_at' => now()
        ]);

        return response()->json(['status' => true, 'message' => __('messages.link_tv_success')]);
    }

    // TV App - Polling to check if confirmed
    public function checkSession(Request $request)
{
    $request->validate([
        'session_id' => 'required|uuid'
    ]);

    $session = TvLoginSession::where('session_id', $request->session_id)
        ->whereNotNull('confirmed_at')
        ->whereColumn('confirmed_at', '<', 'expires_at')
        ->first();

    if (!$session) {
        return response()->json(['status' => 'expired'], 410);
    }

    if ($session->confirmed_at && $session->user_id) {

        $user = User::with('subscriptionPackage')->find($session->user_id);  
        
        if (!$user) {
            return response()->json(['status' => 'user_not_found'], 404);
        }

        Auth::login($user);

        $count = Device::where('user_id', $user->id)->count();

        $devices = Device::where('user_id', $user->id)->get();

        $other_device = [];

        if($devices){

            foreach ($devices as $device) {

                    $other_device[] = $device;
                }
              }

         $other_device= $other_device;

         if (!$request->has('is_demo_user') || $request->is_demo_user != 1) {

            if ($user->subscriptionPackage) {
                $planlimitation = optional(optional($user->subscriptionPackage)->plan)->planLimitation;
    
                if ($planlimitation != null) {
                    $device_limit = $planlimitation->where('limitation_slug', 'device-limit')->first();
                    $device = $device_limit ? $device_limit->limit : 0;
    
                    if ($count == $device) {
                        return response()->json([
                            'error' => 'Your device limit has been reached.',
                            'other_device'=> $other_device
                        ], 406);
                    }
                }
               }else{
    
                    if ($count ==1) {
                        return response()->json([
                            'error' => 'Your device limit has been reached.',
                            'other_device'=> $other_device
                        ], 406);
                    }
                }
    
            }

        if ($user->is_banned == 1 || $user->status == 0) {
                return response()->json(['status' => false, 'message' => __('messages.login_error')]);
            }

        // Save the user
        $user->save();
        $user['api_token'] = $user->createToken(setting('app_name'))->plainTextToken;
           
        if ($user->is_subscribe == 1) {
            $user['plan_details'] = $user->subscriptionPackage;
        }

        $device_id = $request->device_id;
        $device_name = $request->device_name;
        $platform = $request->platform;

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
        $user->session_id = $session->session_id;
        $loginResource = new LoginResource($user);
        
        $message = __('messages.user_login');

        setCurrentProfileSession();
        // dd($loginResource);
        return $this->sendResponse($loginResource, $message);

    }

    return $this->sendError(__('messages.not_matched'), ['error' => __('messages.unauthorised')], 200);
}
}
