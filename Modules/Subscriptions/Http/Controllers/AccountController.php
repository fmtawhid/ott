<?php

namespace Modules\Subscriptions\Http\Controllers;

use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;

class AccountController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'My Subscriptions ';

        // module name
        $this->module_name = 'account';

        // module icon
        $this->module_icon = 'fa-solid fa-user';

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        $user_id = Auth::id();

        $module_action = '';

        $plans = Plan::all();

        $subscription = Subscription::where('user_id', $user_id)->where('status', 'active')->get();

        return view('subscriptions::backend.account.index', compact('module_action', 'plans', 'subscription'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('subscriptions::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('subscriptions::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('subscriptions::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
