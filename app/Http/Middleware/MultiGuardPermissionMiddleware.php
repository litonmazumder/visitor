<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class MultiGuardPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check if user is authenticated on web guard (admin users)
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            // Force fresh check from database by reloading permissions
            $user->load('permissions');
            if (!$user->hasPermissionTo($permission)) {
                return response()->view('errors.403', [], 403);
            }
        }
        // Check if user is authenticated on staff guard (OTP staff)
        elseif (Auth::guard('staff')->check()) {
            $user = Auth::guard('staff')->user();
            // Force fresh check from database by reloading permissions
            $user->load('permissions');
            if (!$user->hasPermissionTo($permission)) {
                return response()->view('errors.403', [], 403);
            }
        }
        // No authenticated user
        else {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        return $next($request);
    }
}