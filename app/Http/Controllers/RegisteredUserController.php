<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use App\Models\User;

class RegisteredUserController extends Controller
{
    
    public function create(){

        return view('auth.register');
    }   

    public function store(){

        $atributes = request()->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', Password::min(6), 'confirmed']
            ]);
    
            // dd(request()->all());
           $user = User::create($atributes);
    
            Auth::login($user);
            
            return redirect('/portal/login');
        }
    
}
