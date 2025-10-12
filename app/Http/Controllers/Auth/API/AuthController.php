<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Auth\Trait\AuthTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\SocialLoginResource;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Artisan;
use App\Models\Device;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeviceEmail;
use App\Mail\sendOtp;
use Jenssegers\Agent\Agent;
use App\Models\UserMultiProfile;
use Modules\Subscriptions\Models\Subscription;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Entertainment\Models\Watchlist;
use Modules\Entertainment\Models\EntertainmentDownload;
use Modules\Entertainment\Models\UserReminder;
use Illuminate\Support\Facades\Storage;
use App\Models\TvLoginSession;

use Exception;

class AuthController extends Controller
{
    use AuthTrait;

    public function register(Request $request)
    {
        $user = $this->registerTrait($request);

        if ($user instanceof \Illuminate\Http\JsonResponse && $user->status() == 422) {
            $message = $user->original['message'] ?? 'The email has already been taken.';
            return response()->json(['message' => $message], 422);
        }

        $success['token'] = $user->createToken(setting('app_name'))->plainTextToken;
        $success['name'] = $user->name;
        $userResource = new RegisterResource($user);

        return $this->sendResponse($userResource, __('messages.register_successfull'));
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::with('subscriptionPackage')->where('email', request('email'))->first();
        if ($user == null) {
            return response()->json(['status' => false, 'message' => __('messages.register_before_login')]);
        }
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

            if ($request->has('is_ajax') && $request->is_ajax == 1) {
                $agent = new Agent();
                $device_id = $request->getClientIp();
                $device_name = $agent->browser();
                $platform = $agent->platform();
            } else {
                $device_id = $request->device_id;
                $device_name = $request->device_name;
                $platform = $request->platform;
            }

            Device::where('user_id', $user->id)
                ->whereIn('platform', ['Windows', 'Linux', 'Mac', 'web'])
                ->where('updated_at', '<', now()->subDays(2))
                ->delete();

            $devices = Device::where('user_id', $user->id)->get();
            $count = $devices->count();

            $existingDevice = Device::where('user_id', $user->id)
                ->where('device_id', $device_id)
                ->first();

            if (!$existingDevice) {
                if ($user->subscriptionPackage) {
                    $planlimitation = optional(optional($user->subscriptionPackage)->plan)->planLimitation;
                    if ($planlimitation) {
                        $device_limit = $planlimitation->where('limitation_slug', 'device-limit')->first();
                        $limit = $device_limit ? $device_limit->limit : 0;

                        if ($count >= $limit) {
                            return response()->json([
                                'error' => 'Your device limit has been reached.',
                                'other_device' => $devices
                            ], 406);
                        }
                    }
                } else {
                    if ($count >= 1) {
                        return response()->json([
                            'error' => 'Your device limit has been reached.',
                            'other_device' => $devices
                        ], 406);
                    }
                }
            }
        }

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();


            if ($user->is_banned == 1 || $user->status == 0) {
                return response()->json(['status' => false, 'message' => __('messages.login_error')]);
            }

            // Save the user
            $user->save();
            $user['api_token'] = $user->createToken(setting('app_name'))->plainTextToken;

            if ($user->is_subscribe == 1) {
                $user['plan_details'] = $user->subscriptionPackage;
                if (isSmtpConfigured()) {
                    // if ($user->subscriptionPackage->device_id != $request->device_id) {
                    //     Mail::to($user->email)->send(new DeviceEmail($user));
                    // }
                }
            }



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

            $loginResource = new LoginResource($user);
            $message = __('messages.user_login');

            setCurrentProfileSession();

            if($request->has('is_ajax') && $request->is_ajax==1 ){

                return $this->sendResponse($loginResource, $message);
            }

            return $this->sendResponse($loginResource, $message);
        } else {
            return $this->sendError(__('messages.not_matched'), ['error' => __('messages.unauthorised')], 200);
        }
    }


    public function socialLogin(Request $request)
    {
        $input = $request->except('file_url');
        if ($input['login_type'] === 'otp') {
            $user_data = User::where('mobile',$input['mobile'])->where('login_type', 'otp')->first();
        } else {
            $user_data = User::where('email', $input['email'])->first();
        }


        if ($user_data != null) {

            $count = Device::where('user_id', $user_data->id)->count();


            if (!$request->has('is_demo_user') || $request->is_demo_user != 1) {
                $planlimitation = optional(optional($user_data->subscriptionPackage)->plan)->planLimitation;
                $devices = Device::where('user_id', $user_data->id)->where('device_id','!=',$request->device_id)->get();

                $other_device = [];

                if($devices){

                    foreach ($devices as $device) {

                            $other_device[] = $device;
                        }
                      }

                 $other_device= $other_device;

                if ($planlimitation != null) {
                    $device_limit = $planlimitation->where('limitation_slug', 'device-limit')->first();
                    $device = $device_limit ? $device_limit->limit : 0;

                    if ($count >= $device) {
                        return response()->json([
                            'error' => 'Your device limit has been reached.',
                            'other_device'=> $other_device
                        ], 406);
                    }
                }else{

                    if ($count >=1 && $other_device != null) {
                        return response()->json([
                            'error' => 'Your device limit has been reached.',
                            'other_device'=> $other_device
                        ], 406);
                    }
                }
            }

            if (!isset($user_data->login_type) || $user_data->login_type == '') {
                if ($request->login_type === 'google') {
                    $message = __('validation.unique', ['attribute' => 'email']);
                } else {
                    $message = __('validation.unique', ['attribute' => 'username']);
                }

                return $this->sendError($message, 400);
            }
            $message = __('messages.login_success');
        } else {
            if ($request->login_type === 'google' || $request->login_type === 'apple') {
                $key = 'email';
                $value = $request->email;
            } else {
                $key = 'username';
                $value = $request->username;
            }

            $trashed_user_data = User::with('subscriptionPackage')->where($key, $value)->whereNotNull('login_type')->withTrashed()->first();

            if ($trashed_user_data != null && $trashed_user_data->trashed()) {
                if ($request->login_type === 'google') {
                    $message = __('validation.unique', ['attribute' => 'email']);
                } else {
                    $message = __('validation.unique', ['attribute' => 'username']);
                }

                return $this->sendError($message, 400);
            }

            if ($request->login_type === 'otp' && $user_data == null) {
                $otp_response = [
                    'status' => true,
                    'is_user_exist' => false,
                ];

                return $this->sendError($otp_response);
            }

            if ($request->login_type === 'otp' && $user_data != null) {
                $otp_response = [
                    'status' => true,
                    'is_user_exist' => true,
                ];

                return $this->sendError($otp_response);
            }

            $password = !empty($input['password']) ? $input['password'] : $input['email'];

            $input['user_type'] = $request->user_type;
            $input['display_name'] = $input['first_name'] . ' ' . $input['last_name'];
            $input['password'] = Hash::make($password);
            $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'user';

            $user = User::create($input);

            $user->assignRole($user->user_type);
            $user->save();
            $user->createOrUpdateProfileWithAvatar();
            // if(!empty($input['file_url'])){
            //     $input['file_url'] = $input['file_url'];
            // $user->update(['file_url' => $input['file_url']]);

            // }
            $user_data = User::where('id', $user->id)->first();

            $message = trans('messages.save_form', ['form' => $input['user_type']]);

        }

        $device = Device::updateOrCreate(
            [
                'user_id' => $user_data->id,
                'device_id' => $request->device_id
            ],
            [
                'device_name' => $request->device_name,
                'platform' => $request->platform
            ]
        );


        $user_data['api_token'] = $user_data->createToken('auth_token')->plainTextToken;

        if ($user_data->is_subscribe == 1) {
            $user_data['plan_details'] = $user_data->subscriptionPackage;
        }

        $socialLogin = new SocialLoginResource($user_data);

        return $this->sendResponse($socialLogin, $message);
    }

    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['status' => false, 'message' => __('messages.user_not_logged_in')]);
        }

        $user = Auth::guard('sanctum')->user();

        // Revoke all tokens associated with the user
        $user->tokens()->delete();


        $tvsession = TvLoginSession::where('user_id', $user->id)->first();
        if($tvsession){
            $tvsession->delete();
        }

        if ($request->has('device_id') && !empty($request->device_id)) {
            // Delete the specific device record if device_id is provided
            Device::where('user_id', $user->id)->where('device_id', $request->device_id)->delete();
        } else {
            // Delete all devices associated with the user
            Device::where('user_id', $user->id)->delete();
        }

        if ($request->is('api*')) {
            return response()->json(['status' => true, 'message' => __('messages.user_logout')]);
        }
    }


    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User with this email does not exist.',
                'status' => false
            ], 404);
        }


        if ($user->login_type == 'otp' && $user->login_type='google') {
            return response()->json([
                'message' => 'User does not have permission to change password.',
                'status' => false
            ], 404);
        }


        // try {
            $response = Password::sendResetLink($request->only('email'));

            return $response === Password::RESET_LINK_SENT
                ? response()->json(['message' => __($response), 'status' => true], 200)
                : response()->json(['message' => __($response), 'status' => false], 400);
        // } catch (Exception $e) {

        //     return response()->json([
        //         'message' => 'There was an issue sending the email. Please check your SMTP configuration.',
        //         'status' => false
        //     ], 500);
        // }
    }



    // public function forgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //     ]);

    //     try {
    //         $response = Password::sendResetLink($request->only('email'));

    //         if ($response === Password::RESET_LINK_SENT) {
    //             return response()->json(['message' => 'Password reset link sent successfully.', 'status' => true], 200);
    //         }

    //         return response()->json(['message' => 'Failed to send password reset link.', 'status' => false], 400);
    //     } catch (Exception $e) {
    //         Log::error('SMTP Error: ' . $e->getMessage());

    //         return response()->json([
    //             'message' => 'There was an issue sending the email. Please check your SMTP configuration.',
    //             'status' => false
    //         ], 500);
    //     }
    // }

    public function changePassword(Request $request)
    {
        $user = \Auth::user();
        $user_id = !empty($request->id) ? $request->id : $user->id;
        $user = User::where('id', $user_id)->first();
        if ($user == '') {
            return response()->json([
                'status' => false,
                'message' => __('messages.user_notfound'),
            ], 400);
        }

        $hashedPassword = $user->password;

        $match = Hash::check($request->old_password, $hashedPassword);

        $same_exits = Hash::check($request->new_password, $hashedPassword);

        if ($match) {
            if ($same_exits) {
                $message = __('messages.old_new_pass_same');

                return response()->json([
                    'status' => false,
                    'message' => __('messages.same_pass'),
                ], 400);
            }

            $user->fill([
                'password' => Hash::make($request->new_password),
            ])->save();

            $success['api_token'] = $user->createToken(setting('app_name'))->plainTextToken;
            $success['name'] = $user->name;

            return response()->json([
                'status' => true,
                'data' => $success,
                'message' => __('messages.pass_successfull'),
            ], 200);
        } else {
            $success['api_token'] = $user->createToken(setting('app_name'))->plainTextToken;
            $success['name'] = $user->name;
            $message = __('messages.valid_password');

            return response()->json([
                'status' => true,
                'data' => $success,
                'message' => __('messages.pass_successfull'),
            ], 200);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = \Auth::user();
        if ($request->has('id') && !empty($request->id)) {
            $user = User::where('id', $request->id)->first();
        }
        if ($user == null) {

            return response()->json([
                'message' => __('messages.no_record'),
            ], 400);
        }

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|unique:users,mobile,' . $user->id,

        ]);


        $data = $request->all();

        $user->update($data);
        if ($request->hasFile('file_url')) {
            $file = $request->file('file_url');

           $activeDisk = env('ACTIVE_STORAGE', 'local');

           $filename = $file->getClientOriginalName();

           if ($activeDisk == 'local') {
            $destinationPath = 'streamit-laravel';
            $filePath = $file->storeAs($destinationPath, $filename, 'public');
            $file_url = '/storage/' . $filePath;

        } else {

            $folderPath = 'streamit-laravel/' .  $filename ;
            Storage::disk( $activeDisk )->put($folderPath, file_get_contents($file));
            $baseUrl = env('DO_SPACES_URL');
            $file_url = $baseUrl . '/' . $folderPath;
        }

            $data['file_url']=extractFileNameFromUrl($file_url);

        } else {
            $data['file_url'] = $user->file_url;
        }
        $user->update(['file_url' => $data['file_url']]);
        $user_data = User::find($user->id);
        $user_data->save();

        $message = __('messages.profile_update');
        $user_data['user_role'] = $user->getRoleNames();
        $user_data['file_url'] = setBaseUrlWithFileName($user->file_url);

        unset($user_data['roles']);
        unset($user_data['media']);

        return response()->json([
            'status' => true,
            'data' => $user_data,
            'message' => $message,
        ], 200);
    }

    public function userDetails(Request $request)
    {
        $userID = $request->id;
        $user = User::find($userID);
        $user['about_self'] = $user->profile->about_self ?? null;
        $user['expert'] = $user->profile->expert ?? null;
        $user['facebook_link'] = $user->profile->facebook_link ?? null;
        $user['instagram_link'] = $user->profile->instagram_link ?? null;
        $user['twitter_link'] = $user->profile->twitter_link ?? null;
        $user['dribbble_link'] = $user->profile->dribbble_link ?? null;

        if (!$user) {
            return response()->json(['status' => false, 'message' => __('messages.user_notfound')], 404);
        }

        return response()->json(['status' => true, 'data' => $user, 'message' => __('messages.user_details_successfull')]);
    }

    public function deleteAccount(Request $request)
    {
        $user_id = \Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        if ($user == null) {
            $message = __('messages.user_not_found');

            return response()->json([
                'status' => false,
                'message' => $message,
            ], 200);
        }
        Device::where('user_id', $user->id)->forceDelete();
        UserMultiProfile::where('user_id', $user->id)->forceDelete();
        Subscription::where('user_id', $user->id)->update(['status' => 'deactivated']);
        User::where('id', $user->id)->forceDelete();
        ContinueWatch::where('user_id', $user->id)->delete();
        Watchlist::where('user_id',$user->id)->delete();
        EntertainmentDownload::where('user_id',$user->id)->delete();
        UserReminder::where('user_id', $user->id)->delete();

        $user->forceDelete();

        $message = __('messages.delete_account');

        return response()->json([
            'status' => true,
            'message' => $message,
        ], 200);
    }


    public function changePin(Request $request)
    {
        (isset($request->pin) && is_array($request->pin)) &&
        $request->merge([
            'pin' => isset($request->pin) ? implode("",$request->pin): NULL,
            'confirm_pin' => isset($request->confirm_pin) ? implode("",$request->confirm_pin) : NULL,
        ]);

        $request->validate([
            'pin' => 'required|min:4|max:4',
            'confirm_pin' => 'required_with:pin|same:pin|min:4|max:4'
        ]);

        $userId = isset($request->user_id) ? $request->user_id : auth()->user()->id;

        if(empty($userId)){
            return response()->json(['status' => false, 'message' => 'Something went wrong please try again.!'],422);
        }
        $user = User::find($userId);

        $message = (!empty($user->otp)) ? __('messages.change_pin_successfull') : __('messages.set_pin_successfull');

        $user->update([
            'pin' => $request->pin,
        ]);

        return response()->json([
            'status' => true,
            'message' => $message,
        ], 200);
    }

    /**
     * otp resend/send on email
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {
        $userId = isset($request->user_id) ? $request->user_id : auth()->user()->id;
        if(empty($userId)){
            return response()->json(['status' => false, 'message' => 'Something went wrong please try again.!'],422);
        }
        $user = User::find($userId);
        if($user){
            $otp = rand(1000,9999);
            $user->update(['otp' => $otp]);


            $bodyData = ['body' => 'Change Your Pin OTP is : '. $otp];
            Mail::to($user->email)->send(new sendOtp($bodyData));

            return response(["status" => true, "message" => "OTP sent successfully"],200);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong please try again.!'],422);
        }
    }

    /**
     * verify email otp
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request)
    {
        $userId = isset($request->user_id) ? $request->user_id : auth()->user()->id;
        if(empty($userId)){
            return response()->json(['status' => false, 'message' => 'Something went wrong please try again.!'],422);
        }

        (isset($request->otp) && is_array($request->otp)) &&
        $request->merge([
            'otp' => isset($request->otp) ? implode("",$request->otp): NULL
        ]);

        $request->validate([
            'otp' => 'required|min:4|max:4'
        ]);

        $user  = User::where([['id','=',$userId],['otp','=',$request->otp]])->first();
        if($user){

            return response(["status" => true, "message" => "OTP verified successfully"],200);
        } else{
            return response(["status" => false, 'message' => 'Invalid Otp'],200);
        }
    }

    /**
     * verify pin
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function verifyPin(Request $request)
    {

        $userId = isset($request->user_id) ? $request->user_id : auth()->user()->id;
        if(empty($userId)){
            return response()->json(['status' => false, 'message' => 'Something went wrong please try again.!'],422);
        }

        (isset($request->pin) && is_array($request->pin)) &&
        $request->merge([
            'pin' => isset($request->pin) ? implode("",$request->pin): NULL
        ]);

        $request->validate([
            'pin' => 'required'
        ]);

        $user  = User::where([['id','=',$userId],['pin','=',$request->pin]])->first();
        if($user){
            return response(["status" => true, "message" => "Pin verified successfully"],200);
        } else{
            return response(["status" => false, 'message' => 'Invalid Pin'], 200);
        }
    }

    /**
     * change parental pin flag
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function changeParentalLock(Request $request)
    {
        $userId = isset($request->user_id) ? $request->user_id : auth()->user()->id;
        if(empty($userId)){
            return response()->json(['status' => false, 'message' => 'Something went wrong please try again.!'],422);
        }

        $request->validate([
            'is_parental_lock_enable' => 'required|in:0,1'
        ]);

        $user  = User::where('id',$userId)->update([
            'is_parental_lock_enable' => $request->is_parental_lock_enable
        ]);
        if($user){
            return response(["status" => true, "message" => "Successfully updated"],200);
        } else{
            return response(["status" => false, 'message' => 'Something went wrong please try again.!'],422);
        }
    }
}
