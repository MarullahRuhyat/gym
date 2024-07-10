<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginAdminIndex()
    {
        return view('auth.login-admin');
    }

    function loginAdminProcess(Request $request)
    {
        $credentials = $request->only('phone_number', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin_dashboard');
            } elseif (Auth::user()->role == 'personal trainer') {
                return redirect()->route('personal_trainer.attendance_member');
            }
        }
        return redirect()->back()->with('error', 'The provided credentials do not match our records.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }  
}
