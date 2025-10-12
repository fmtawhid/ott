<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;

class CheckDeviceAuthorization
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Skip check for admin users
            if ($user->hasRole('admin') || $user->hasRole('demo_admin')) {
                return $next($request);
            }
            
            $serverName = $request->server('SERVER_NAME');
            
            $deviceExists = Device::where('user_id', $user->id)
                ->when($serverName, function($query) use ($serverName) {
                    return $query->where('device_id', $serverName);
                })
                ->exists();
            
            if (!$deviceExists) {
                Auth::logout();
                session()->flush();
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Device not authorized'
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->with('error', 'Your device is no longer authorized. Please login again.');
            }
        }
    
        return $next($request);
    }
}