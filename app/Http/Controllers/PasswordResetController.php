<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    
    public function forgot_pass(){

        return view('auth.forgot');
    }

}
