<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function loginAdminIndex(Request $request)
    {
        $phone_number = $request->cookie('phone_number');
        $password = $request->cookie('password');
        $remember = $request->cookie('remember_me');
        if($remember == '1'){
            $remember = $request->has('remember_me');
        }
        return view('auth.login-admin', compact('phone_number', 'password', 'remember'));
    }

    function loginAdminProcess(Request $request)
    {
        $remember = $request->has('remember_me') ? true : false;
        $credentials = $request->only('phone_number', 'password');
        if (Auth::attempt($credentials)) {
            if ($remember == true) {
                Cookie::queue('phone_number', $request->phone_number, 60 * 24 * 30);
                Cookie::queue('password', $request->password, 60 * 24 * 30); 
            }
            elseif ($remember == false) {
                Cookie::queue(Cookie::forget('phone_number'));
                Cookie::queue(Cookie::forget('password'));
            }


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
