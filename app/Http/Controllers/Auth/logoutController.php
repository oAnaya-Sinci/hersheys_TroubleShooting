<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    public function logout(request $request){

        auth()->logout();
        return true;

        // return redirect('/login');
        // return view('auth/login');
    }
}
