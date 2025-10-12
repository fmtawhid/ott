<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMultiProfile;
use App\Models\Device;
use Modules\User\Transformers\UserMultiProfileResource;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;

class UserMultiProfileController extends Controller
{
    public function profileList(Request $request)
    {
        $user_id = !empty($request->user_id)? $request->user_id :auth()->user()->id;

        $perPage = $request->input('per_page', 10);
        $profiles = UserMultiProfile::with('user');
        
        $profiles = $profiles->where('user_id', operator: $user_id)->paginate($perPage);

        $responseData = UserMultiProfileResource::collection($profiles);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('movie.profile_list'),
        ], 200);
    }

    public function saveProfile(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        if(isset($request->id) && !empty($request->id))
        {
            $profilesCheck = UserMultiProfile::where('user_id', $user->id);

            if ($profilesCheck->count('id') <= 1 && $data['is_child_profile'] == 1) {
                return response()->json([
                    'error' => 'If you only have one parent profile, you can`t convert it to a child profile'
                ], 406);
            }

            $proCheck = UserMultiProfile::where([
                'is_child_profile' => 0,
                'user_id' => $user->id
            ])->where('id','!=',$request->id)->count('id');


            if ($proCheck < 1 && $data['is_child_profile'] == 1) {
                return response()->json([
                    'error' => 'Atleast one parent profile is required'
                ], 406);
            }
        }

        $avatar = $data['avatar'] ?? $user->generateAvatar($data['name']);

        $profile_data = [
            'user_id' => $user->id,
            'name'    => $data['name'],
            'avatar'  => $avatar
        ];

        $profile_data['is_child_profile'] = isset($data['is_child_profile']) ? $data['is_child_profile'] : 0;

        $profile_count = UserMultiProfile::where('user_id', $user->id)->count();

        if (empty($request->id)) {
            $max_profiles = $user->is_subscribe ? $this->getSubscriptionProfileLimit($user) : 1;

            if ($profile_count >= $max_profiles) {
                return response()->json([
                    'error' => 'You’ve reached the profile limit for your current plan. Upgrade to add more profiles.'
                ], 406);
            }
        }

        $user_profile = UserMultiProfile::updateOrCreate(
            ['user_id' => $user->id, 'id' => $request->id],
            $profile_data
        );


        if ($request->hasFile('file_url')) {

            $file = $request->file('file_url');

            $destinationPath = 'avatars';

            $filename = $file->getClientOriginalName();
            $filePath = $file->storeAs($destinationPath, $filename, 'public');

            $file_url = '/storage/' . $filePath;

            $avatar=setavatarBaseUrl($file_url);

            $user_profile->update(['avatar'=> $avatar]);

        }

        $profiles = UserMultiProfile::where('user_id', $user->id)->get();
        $responseData = UserMultiProfileResource::collection($profiles);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'user_profile' => $user_profile,
            'message' =>__('messages.profile_update')
        ]);
    }


private function getSubscriptionProfileLimit($user)
{
    $plan_limitation = optional(optional($user->subscriptionPackage)->plan)->planLimitation;

    if ($plan_limitation) {
        $profile_limit = $plan_limitation->where('limitation_slug', 'profile-limit')->first();
        return $profile_limit ? $profile_limit->limit : 1;
    }

    return 0;
}

    public function getprofile(Request $request, $id)
    {
        $user_id = !empty($request->user_id)? $request->user_id :auth()->user()->id;

        $profile = UserMultiProfile::where('id', $request->id)->first();

        $responseData = New UserMultiProfileResource($profile);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('messages.profile_update'),
        ], 200);
    }

    public function SelectProfile(Request $request, $id)
{
    Cache::flush();
    $user_id = $request->user_id ?? auth()->id();
    $device = Device::where('user_id', $user_id)
                    ->where('device_id', $request->ip())
                    ->orderBy('id','DESC')
                    ->first();

    if ($device) {

        Device::where('user_id', $user_id)
                ->where('device_id', $request->ip())
                ->where('id','!=',$device->id)
                ->delete();

        $device->update(['active_profile' => $id]);
    } else {
        $agent = new Agent();
        $device_id = $request->getClientIp();
        $device_name =  $agent->browser();
        $platform = $agent->platform();

        $device = Device::create([
                'user_id' => $user_id,
                'device_id' => $device_id,
                'device_name' => $device_name,
                'platform' => $platform,
                'active_profile' => $id
            ]);
        // return response()->json([
        //     'status' => false,
        //     'message' => __('users.device_not_found'),
        // ], 404);
    }

    $profiles = UserMultiProfile::where('user_id', $user_id)->get();

    $responseData = UserMultiProfileResource::collection($profiles);

    setCurrentProfileSession(1,$id);

    return response()->json([
        'status' => true,
        'data'=>$responseData,
        'message' => __('movie.profile_selected'),
    ], 200);
}



    public function deleteProfile(Request $request)
    {
        $user = auth()->user();

        $profile = UserMultiProfile::where('user_id', $user->id)->where('id', $request->profile_id)->first();

        if ($profile == null) {

            $message = __('movie.profile');

            return response()->json(['status' => false, 'message' => $message]);
        }
        $profile->delete();
        $message = __('movie.profile_delete');


        return response()->json(['status' => true, 'message' => $message]);
    }

}
