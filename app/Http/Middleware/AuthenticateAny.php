<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateAny
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // If ANY guard is logged in, allow the request to continue.
        if (Auth::guard('web')->check() || Auth::guard('staff')->check()) {
            return $next($request);
        }

        // Not authenticated on any guard: redirect to login.
        return redirect()->route('login')
            ->with('error', 'Please log in to access the portal.');
    }
}