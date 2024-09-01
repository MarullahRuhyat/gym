<?php

namespace App\Http\Controllers\auth;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function loginAdminIndex(Request $request)
    {
        $phone_number = $request->cookie('phone_number');
        $password = $request->cookie('password');
        $remember = $request->cookie('remember_me');
        if ($remember == '1') {
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
            } elseif ($remember == false) {
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

    public function forgotPassword()
    {
        return view('auth.forget-password');
    }

    public function forgotPasswordProcess(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user) {
            // Generate OTP dan set waktu kedaluwarsa
            $otp = rand(100000, 999999); // OTP 6 digit
            $otp_expired_at = Carbon::now()->addMinutes(10);

            // Update database dengan OTP dan waktu kedaluwarsa
            $user->otp = $otp;
            $user->otp_expired_at = $otp_expired_at;
            $user->save();

            // Mengirim OTP melalui WhatsApp menggunakan Guzzle dan Wablas API
            $url = "https://jogja.wablas.com";
            $token = "SujEXjKi5MEvVWebuRK17sG4H69mKzZwFD4Uca7HPrPwNiQawGLJ4ShA5uCCaUtv"; // Ganti dengan token Wablas yang valid
            $mobileNumber = $user->phone_number;
            $message = "Your OTP code is: https://admin.flozorsgym.com/auth/verify-otp?otp=$otp .This code will expire in 10 minutes.";

            $client = new Client(['base_uri' => $url]);

            try {
                $response = $client->post('/api/send-message', [
                    'form_params' => [
                        'phone' => $mobileNumber,
                        'message' => $message
                    ],
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'Authorization' => $token
                    ]
                ]);

                $body = json_decode($response->getBody(), true);

                if ($body['status'] == true && $response->getStatusCode() == 200) {
                    return redirect()->back()->with('success', 'OTP has been sent to your WhatsApp.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send OTP via WhatsApp. ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Phone number not found.');
    }

    public function verifyOtp(Request $request)
    {
        $otp = $request->otp;
        $user = User::where('otp', $otp)->where('otp_expired_at', '>=', Carbon::now())->first();

        if ($user) {
            return view('auth.reset-password', compact('otp'));
        }

        return 404;
    }

    public function verifyOtpProcess(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'password' => 'required|confirmed',
        ]);
        
        $otp = $request->otp;
        $password = $request->password;

        $user = User::where('otp', $otp)->where('otp_expired_at', '>=', Carbon::now())->first();

        if ($user) {
            $user->password = bcrypt($password);
            $user->otp = null;
            $user->otp_expired_at = null;
            $user->save();

            return redirect()->route('auth.login')->with('success', 'Password has been reset. Please login with your new password.');
        }

        return redirect()->back()->with('error', 'Failed to reset password. OTP is invalid or has expired.');
        
    }
}
