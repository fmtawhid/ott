<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FCM;

class FCMController extends Controller
{
    // List notifications
    public function index(Request $request)
{
    $query = FCM::query();

    // Search by title or message
    if ($search = $request->input('search')) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
    }

    $notifications = $query->latest()->paginate(10)->withQueryString();

    return view('fcm_index', compact('notifications', 'search'));
}


    // Form to create new notification
    public function createForm()
    {
        return view('fcm'); // Blade form
    }

    // Store the FCM notification
    public function store(Request $request)
    { 
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $destinationPath = public_path('uploads/fcm_images');
            $image->move($destinationPath, $imageName);
            $imagePath = 'uploads/fcm_images/' . $imageName;
        }

        // Create notification — this will automatically send to all devices
        FCM::create([
            'title' => $request->title,
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Notification created & sent to all devices!');
    }

    // Delete notification
    public function destroy($id)
    {
        $notification = FCM::findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notification deleted successfully!');
    }
}
