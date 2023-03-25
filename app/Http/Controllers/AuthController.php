<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Login successfully!');
        }
        return redirect("login")->withSuccess('Invalid credentials!');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login')->withSuccess('Logout successfully!');;
    }
}
