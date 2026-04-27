<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function __invoke()
    {
        return response()
            ->view('your-view') // Replace 'your-view' with the actual view name
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Cache-Control', 'post-check=0, pre-check=0', false)
            ->header('Pragma', 'no-cache');
    }

    public function create(){

        return view('auth.login');
    }


    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    
        // If authentication fails, redirect back with an error message
        if (!Auth::attempt($attributes)) {
            return back()->withInput()->with('auth_error', 'Invalid credentials, please try again.');
        }
    
        // If authentication succeeds, regenerate the session and redirect to the admin page
        request()->session()->regenerate();
    
        return redirect()->intended(route('dashboard'));
    }
    
    public function destroy(Request $request)
    {
        // Log out the user
        Auth::logout();
    
        // Invalidate the session to remove all session data
        $request->session()->invalidate();
    
        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();
    
        // Redirect to the login page with a success message
        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
