<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Controller
{
    function handler(Request $request)
    {
        Auth::logout();
        Session::regenerate();
        return redirect()->to(route('Auth.Login'));
    }
}
