<?php


namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Str;
use App\Models\Device;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeviceEmail;
use App\Models\Setting;
use Jenssegers\Agent\Agent;
use App\Models\UserMultiProfile;
use Modules\Frontend\Trait\LoginTrait;



class OTPController extends Controller
{
    use LoginTrait;

    public function otpLogin()
    {
        $userId = auth()->id();
                $settings = Setting::getAllSettings($userId);
        $isOtpLoginEnabled = Setting::where('name', 'is_otp_login')->value('val') == 1;

        return view('frontend::auth.otp_login', compact('settings', 'isOtpLoginEnabled'));
    }

    public function otpLoginStore(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' =>  $request->email,
            'mobile' =>  $request->mobile,
            'password' => Hash::make($request->password), 
            'user_type' => 'user',
            'login_type' => 'otp'
        ];

        // $user = User::where('email', $request->email)->first();

        $user = User::create($data);


        // $request->session()->regenerate();

        $user->createOrUpdateProfileWithAvatar();

        $user->assignRole($data['user_type']);

        $user->save();

        if ($user->login_type == 'otp') {
            Auth::login($user);
            $this->setDevice($user, $request);
        } else {
            $user = Auth::user();
            Auth::logout();
            $this->removeDevice($user, $request);
            return Redirect::to('/login')->with('error', 'Something went wrong! During login');
        }

        return redirect('/'); // Redirect to intended page
    }

    public function checkUserExists(Request $request)
    {
        $data = $request->all();

        $current_device = $request->has('device_id') ? $request->device_id : $request->getClientIp();

        $flag = 0;
        $user = User::where('mobile', $request->mobile)->where('login_type', 'otp')->with('subscriptionPackage')->first();

        if (!empty($user)) {

            if ($user->user_type != 'user') {

                return response()->json(['message' => "Admin doesn't have access to login", 'status' => 406]);
            }

            $response = $this->CheckDeviceLimit($user, $current_device);

            if (isset($response['error'])) {

                return response()->json(['message' => $response['error'], 'status' => 406]);
            }

            $this->setDevice($user, $request);

            Auth::login($user);
            $flag = 1;
        }

        return response()->json(['is_user_exists' => $flag, 'url' => route('user.login')]);
    }

    // public function sendOtp(Request $request)
    // {

    //     // dd($request->all());

    //     $mobile = $request->mobile;
    //     $otp = rand(100000, 999999);

    //     $message = "Welcome to Zatra TV your login OTP: $otp";


    //     $api_key = 'usqk2jE0QEKYvxV7QH47';
    //     $senderid = '8809648904260';

    //     $url = "http://bulksmsbd.net/api/smsapi?api_key={$api_key}&type=text&number={$mobile}&senderid={$senderid}&message=" . urlencode($message);

    //     try {
    //         $response = file_get_contents($url);
    //         session(['otp' => $otp, 'mobile' => $mobile]);
    //         return redirect('/verify-otp');
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to send OTP',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;
        $otp = rand(100000, 999999);

        // Save OTP & mobile in session
        session(['otp' => $otp, 'mobile' => $mobile]);

        // Send SMS
        $message = "Welcome to Zatra TV your login OTP: $otp";
        $api_key = 'usqk2jE0QEKYvxV7QH47';
        $senderid = '8809648904260';
        $url = "http://bulksmsbd.net/api/smsapi?api_key={$api_key}&type=text&number={$mobile}&senderid={$senderid}&message=" . urlencode($message);
        file_get_contents($url);

        return redirect()->route('verify.otp.page');
    }



    public function verifyOtpPage()
    {

        return view('frontend::auth.otp_verify');
    }

    public function otpRegister()
    {
        return view('frontend::auth.register');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'otp' => 'required'
        ]);

        $sessionMobile = session('mobile');
        $sessionOtp = session('otp');

        // OTP mismatch check
        if ($sessionOtp != $request->otp || $sessionMobile != $request->mobile) {
            return redirect()->back()->with('error', 'Invalid OTP');
        }

        // Check if user exists by mobile and login_type
        $user = User::where('mobile', $request->mobile)
                    ->where('login_type', 'otp')
                    ->first();

        if ($user) {
            // Login existing user
            Auth::login($user);
            $request->session()->regenerate(); // important

            // Clear OTP session
            session()->forget(['otp', 'mobile']);

            // Optional: set device if you have device tracking
            $this->setDevice($user, $request);

            return redirect('/'); // home page
        }

        // New user -> store mobile in session & redirect to registration
        session(['mobile' => $request->mobile]);
        return redirect()->route('otp.register');
    }

}
