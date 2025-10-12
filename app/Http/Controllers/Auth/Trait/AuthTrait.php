<?php

namespace App\Http\Controllers\Auth\Trait;

use App\Events\Auth\UserLoginSuccess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

trait AuthTrait
{
    protected function loginTrait($request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember_me;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
            $user = auth()->user();
            if($user->hasRole('user')){
                Auth::logout();
               return ['status' => 406, 'message' => 'Unauthorized role & The provided credentials do not match our records'];
            }

            event(new UserLoginSuccess($request, auth()->user()));
            return ['status' => 200, 'message' => 'Login successful!'];
        }
        return false;
    }

    protected function registerTrait($request, $model = null)
    {

        try {
            $request->validate([
                'first_name' => ['required', 'string', 'max:191'],
                'last_name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return response()->json(['message' => 'The email has already been taken.'], 422);
        }
        $arr = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
            'user_type' => 'user',
            'login_type' => $request->login_type,
        ];
        if (isset($model)) {
            $user = $model::create($arr);
        } else {
            $user = User::create($arr);
        }
        $user->createOrUpdateProfileWithAvatar();
        $user->assignRole($user->user_type);
        $user->save();
        // event(new Registered($user));
        // event(new UserRegistered($user));

        return $user;
    }
}
