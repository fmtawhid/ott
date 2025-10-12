<?php

namespace Modules\Frontend\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Cache;
use Modules\Frontend\Trait\LoginTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OTPApiController extends Controller
{
    use LoginTrait;

    /**
     * Send OTP to mobile (BD) — accepts 01XXXXXXXXX / 8801XXXXXXXXX / +8801XXXXXXXXX
     * Stores OTP keyed by local (01...) form, sends SMS to intl (8801...) form.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'regex:/^(?:\+?8801\d{9}|01\d{9}|8801\d{9})$/'],
        ]);

        Log::info("API Send OTP Request:", $request->all());

        try {
            $normalized = $this->normalizeBdMobile($request->mobile);
        } catch (\InvalidArgumentException $e) {
            Log::error("Invalid mobile format for BD: ".$request->mobile);
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid Bangladeshi mobile number.',
            ], 422);
        }

        $mobileLocal = $normalized['local']; // 01XXXXXXXXX
        $smsMobile   = $normalized['intl'];  // 8801XXXXXXXXX

        $otp = random_int(100000, 999999);

        Log::info("Generated OTP:", ['otp' => $otp, 'mobileLocal' => $mobileLocal, 'smsMobile' => $smsMobile]);

        // Save OTP in cache for 5 minutes using local format as the key
        Cache::put("otp_{$mobileLocal}", $otp, now()->addMinutes(5));

        // Verify OTP is cached
        $cachedOtp = Cache::get("otp_{$mobileLocal}");
        Log::info("Cached OTP Check:", ['cached' => $cachedOtp, 'key' => "otp_{$mobileLocal}"]);

        // Send SMS
        $message  = "Welcome to Zatra TV your login OTP: $otp";
        $api_key  = env('BULKSMS_API_KEY', 'usqk2jE0QEKYvxV7QH47');      // move to .env
        $senderid = env('BULKSMS_SENDER_ID', '8809648904260');            // move to .env

        $url = "http://bulksmsbd.net/api/smsapi?api_key={$api_key}"
             . "&type=text&number={$smsMobile}&senderid={$senderid}&message=" . urlencode($message);

        Log::info("SMS API URL:", ['url' => $url]);

        try {
            $response = $this->sendSMS($url);
            Log::info("SMS API Response:", ['response' => $response]);

            return response()->json([
                'status'  => 'success',
                'message' => 'OTP sent successfully',
                // Remove in production:
                'debug'   => [
                    'mobile_input' => $request->mobile,
                    'mobile_local' => $mobileLocal,
                    'mobile_sms'   => $smsMobile,
                    'otp'          => $otp,
                    'response'     => $response,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('SMS sending failed: '.$e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to send OTP. Please try again.',
            ], 500);
        }
    }

    /**
     * Verify OTP and login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'regex:/^(?:\+?8801\d{9}|01\d{9}|8801\d{9})$/'],
            'otp'    => 'required|digits:6',
        ]);

        Log::info("API Verify OTP Request:", $request->all());

        try {
            $normalized = $this->normalizeBdMobile($request->mobile);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid Bangladeshi mobile number.',
            ], 422);
        }

        $mobileLocal = $normalized['local']; // cache key & DB key

        $cachedOtp = Cache::get("otp_{$mobileLocal}");
        Log::info("OTP Verification Check:", [
            'mobile_local' => $mobileLocal,
            'input_otp'    => $request->otp,
            'cached_otp'   => $cachedOtp,
        ]);

        if (!$cachedOtp || (string)$cachedOtp !== (string)$request->otp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid OTP',
            ], 422);
        }

        // First try the canonical stored format. If legacy rows exist with intl format, include both.
        $user = User::where('login_type', 'otp')
                    ->whereIn('mobile', [$mobileLocal, $normalized['intl']])
                    ->first();

        if ($user) {
            // Check device limit before login
            $current_device = $request->has('device_id') ? $request->device_id : $request->getClientIp();
            $deviceCheck = $this->CheckDeviceLimit($user, $current_device);

            if (isset($deviceCheck['error'])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $deviceCheck['error'],
                ], 406);
            }

            $token = $user->createToken('api-token')->plainTextToken;
            Cache::forget("otp_{$mobileLocal}");

            // Device tracking (best-effort)
            try {
                $this->setDevice($user, $request);
            } catch (\Exception $e) {
                Log::error('Device tracking failed: '.$e->getMessage());
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Login successful',
                'token'   => $token,
                'user'    => [
                    'id'     => $user->id,
                    'name'   => trim($user->first_name.' '.$user->last_name),
                    'email'  => $user->email,
                    'mobile' => $user->mobile,
                ],
            ]);
        }

        // User not found -> ask to register
        return response()->json([
            'status'  => 'register_required',
            'message' => 'User not found, please complete registration',
            'mobile'  => $mobileLocal,
        ]);
    }

    /**
     * Register new user via OTP
     */
    public function otpRegister(Request $request)
    {
        $request->validate([
            'mobile'                  => ['required', 'regex:/^(?:\+?8801\d{9}|01\d{9}|8801\d{9})$/'],
            'first_name'              => 'required|string|max:255',
            'last_name'               => 'nullable|string|max:255',
            'email'                   => 'required|email|unique:users,email',
            'password'                => 'required|string|min:6|confirmed',
        ]);

        Log::info("API OTP Register Request:", $request->all());

        try {
            $normalized = $this->normalizeBdMobile($request->mobile);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid Bangladeshi mobile number.',
            ], 422);
        }

        $mobileLocal = $normalized['local'];

        // If any existing user has local or intl stored, block
        $existingUser = User::whereIn('mobile', [$mobileLocal, $normalized['intl']])->first();
        if ($existingUser) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Mobile number already registered',
            ], 422);
        }

        $user = User::create([
            'mobile'     => $mobileLocal, // store canonical local form
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'user_type'  => 'user',
            'login_type' => 'otp',
        ]);

        $user->assignRole('user');
        $user->createOrUpdateProfileWithAvatar();

        $token = $user->createToken('api-token')->plainTextToken;

        // Device tracking (best-effort)
        try {
            $this->setDevice($user, $request);
        } catch (\Exception $e) {
            Log::error('Device tracking failed: '.$e->getMessage());
        }

        Log::info("New user registered via OTP:", ['user_id' => $user->id]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registration successful',
            'token'   => $token,
            'user'    => [
                'id'     => $user->id,
                'name'   => trim($user->first_name.' '.$user->last_name),
                'email'  => $user->email,
                'mobile' => $user->mobile, // stored as 01XXXXXXXXX
            ],
        ]);
    }

    /**
     * Check if user exists by mobile
     */
         public function checkUserExists(Request $request)
{
    $request->validate([
        'mobile' => ['required', 'regex:/^(?:\+?8801\d{9}|01\d{9}|8801\d{9})$/'],
    ]);

    try {
        $normalized = $this->normalizeBdMobile($request->mobile);
    } catch (\InvalidArgumentException $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid Bangladeshi mobile number.',
        ], 422);
    }

    $mobileLocal = $normalized['local'];
    $mobileIntl  = $normalized['intl'];

    // 🔑 Flexible query (যেকোনো format match করবে)
    $user = User::where('login_type', 'otp')
        ->where(function ($q) use ($mobileLocal, $mobileIntl) {
            $q->where('mobile', $mobileLocal)
              ->orWhere('mobile', $mobileIntl)
              ->orWhere('mobile', ltrim($mobileIntl, '+'))
              ->orWhere('mobile', ltrim($mobileLocal, '0')); 
        })
        ->first();

    $current_device = $request->has('device_id') ? $request->device_id : $request->getClientIp();

    if ($user) {
        // ✅ Device limit check
        $deviceCheck = $this->CheckDeviceLimit($user, $current_device);
        if (isset($deviceCheck['error'])) {
            return response()->json([
                'status'         => false,
                'is_user_exists' => true,
                'can_login'      => false,
                'message'        => $deviceCheck['error'],
            ]);
        }

        // ✅ Issue API token (same as login)
        $token = $user->createToken('API Token')->plainTextToken;

        // ✅ Fetch subscription/plan details if needed
        // $plan = $user->plan()->with('planType')->first();

        return response()->json([
            'status'         => true,
            'is_user_exists' => true,
            'can_login'      => true,
            'data'           => [
                'id'            => $user->id,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'email'         => $user->email,
                'mobile'        => $user->mobile,
                'api_token'     => $token,
                'full_name'     => $user->full_name,
                'profile_image' => $user->profile_image,
                
            ],
            'message'        => 'User exists and logged in successfully',
        ]);
    }

    return response()->json([
        'status'         => true,
        'is_user_exists' => false,
        'can_login'      => false,
        'message'        => 'User not found',
    ]);
}
    // public function checkUserExists(Request $request)
    // {
    //     $request->validate([
    //         'mobile' => ['required', 'regex:/^(?:\+?8801\d{9}|01\d{9}|8801\d{9})$/'],
    //     ]);

    //     try {
    //         $normalized = $this->normalizeBdMobile($request->mobile);
    //     } catch (\InvalidArgumentException $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Invalid Bangladeshi mobile number.',
    //         ], 422);
    //     }

    //     $mobileLocal = $normalized['local'];

    //     $user = User::where('login_type', 'otp')
    //                 ->whereIn('mobile', [$mobileLocal, $normalized['intl']])
    //                 ->first();

    //     $current_device = $request->has('device_id') ? $request->device_id : $request->getClientIp();

    //     if ($user) {
    //         // Check device limit
    //         $deviceCheck = $this->CheckDeviceLimit($user, $current_device);
    //         $can_login   = !isset($deviceCheck['error']);

    //         return response()->json([
    //             'status'         => 'success',
    //             'is_user_exists' => true,
    //             'can_login'      => $can_login,
    //             'message'        => $can_login ? 'User exists and can login' : $deviceCheck['error'],
    //         ]);
    //     }

    //     return response()->json([
    //         'status'         => 'success',
    //         'is_user_exists' => false,
    //         'message'        => 'User not found',
    //     ]);
    // }

    /**
     * Normalize BD mobile:
     *  - Input: 01XXXXXXXXX, 8801XXXXXXXXX, +8801XXXXXXXXX, 008801XXXXXXXXX
     *  - Output:
     *      ['local' => 01XXXXXXXXX, 'intl' => 8801XXXXXXXXX]
     */
    private function normalizeBdMobile(string $raw): array
    {
        $digits = preg_replace('/\D+/', '', $raw);

        // Strip leading 00 (e.g., 0088017...)
        if (Str::startsWith($digits, '00')) {
            $digits = substr($digits, 2);
        }

        // E.164 without plus or with plus stripped -> 8801XXXXXXXXX
        if (Str::startsWith($digits, '8801') && strlen($digits) === 13) {
            $local = '0' . substr($digits, 3); // 880 + 1XXXXXXXXX -> 01XXXXXXXXX
            return ['local' => $local, 'intl' => $digits];
        }

        // Local 01XXXXXXXXX (11 digits)
        if (Str::startsWith($digits, '01') && strlen($digits) === 11) {
            return ['local' => $digits, 'intl' => '880' . substr($digits, 1)]; // drop leading 0, add 880
        }

        throw new \InvalidArgumentException('Invalid Bangladeshi mobile number format.');
    }

    /**
     * Send SMS with multiple fallback methods
     */
    private function sendSMS(string $url)
    {
        // Method 1: file_get_contents
        try {
            $response = @file_get_contents($url);
            if ($response !== false) {
                Log::info("SMS sent via file_get_contents");
                return $response;
            }
        } catch (\Throwable $e) {
            Log::warning("file_get_contents failed: " . $e->getMessage());
        }

        // Method 2: cURL
        $ch = curl_init();
        if ($ch === false) {
            throw new \RuntimeException('Unable to init cURL');
        }

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        Log::info("SMS sent via CURL", [
            'http_code'  => $httpCode,
            'curl_error' => $curlError,
            'response'   => $response,
        ]);

        if ($response === false) {
            throw new \RuntimeException('CURL Error: ' . $curlError);
        }

        return $response;
    }
}
