<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Trait\AuthTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class AuthenticatedSessionController extends Controller
{
    use AuthTrait;

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $isLogin = $this->loginTrait($request);
        if ($isLogin) {

            if (isset($isLogin['error'])) {

                return back()->withErrors([
                    'email' => $isLogin['error']
                ])->onlyInput('email');
            } elseif ($isLogin['status'] == 406) {

                return back()->withErrors([
                    'email' => $isLogin['message']
                ])->onlyInput('email');

            } else {

                $request->session()->regenerate();

                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                Artisan::call('config:cache');
                Artisan::call('route:clear');



            return redirect('app/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
