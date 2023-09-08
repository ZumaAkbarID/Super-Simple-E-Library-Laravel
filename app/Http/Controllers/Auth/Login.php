<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Login extends Controller
{
    function form()
    {
        return view('Auth.Login', [
            'title' => parent::title('Login Perpustakaan')
        ]);
    }

    function handler(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
            ]
        );

        $rememberMe = ($request->exists('rememberMe') || $request->rememberMe == 'on') ? true : false;

        try {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $rememberMe)) {
                return redirect()->intended(route('Dashboard'));
            } else {
                return redirect()->back()->with('error', 'Informasi akun tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Informasi akun tidak ditemukan');
        }
    }
}