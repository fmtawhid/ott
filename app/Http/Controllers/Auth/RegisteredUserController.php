<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Trait\AuthTrait;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    use AuthTrait;

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $user = $this->registerTrait($request);

        $user = Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
