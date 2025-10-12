<?php

namespace Modules\Frontend\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserMultiProfile;
use Modules\User\Transformers\UserMultiProfileResource;
use Auth;
use Hash;
class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function securityControl()
    {
        $user = Auth::user();

        $Profile=UserMultiProfile::where('user_id', $user->id)->get();

        $userProfile = UserMultiProfileResource::collection($Profile);

        return view('frontend::securityControl',compact('user','userProfile'));
    }

//     public function securityControlForm()
// {
//     $user = Auth::user();

//     // Return only the partial form, not the full page
//     if (empty($user->pin)) {
//         return view('security-control'); // create this blade partial with your set PIN form HTML
//     } else {
//         return view('frontend::partials.change_pin_form'); // create this blade partial with your change PIN form HTML
//     }
// }
    /**
     * Display a listing of the resource.
     */
    public function editProfile()
    {
        $user =Auth::user();

        $dev = Device::where('user_id', $user->id)
                ->where('device_id', request()->ip())
                ->orderBy('id','DESC')
                ->get();

        if(count($dev) > 1)
        {
            Device::where('user_id', $user->id)
                ->where('device_id', request()->ip())
                ->where('id','!=',$dev[0]->id)
                ->delete();
        }

        $Profile=UserMultiProfile::where('user_id', $user->id)->get();
        $profileCount = $Profile->count();
        $userProfile = UserMultiProfileResource::collection($Profile);

        return view('frontend::editProfile',compact('user','userProfile','profileCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('frontend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('frontend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(UserMultiProfile $profile)
{
    $user = auth()->user();

    if ($profile->user_id !== $user->id) {
        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }

    $profile->delete();

    return response()->json(['success' => true, 'message' => 'Profile deleted successfully.']);
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => ['required','confirmed','min:8','different:old_password',
            ],

        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['old_password' => 'The old password is incorrect.'],
            ], 422);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['success' => true]);
    }

}
