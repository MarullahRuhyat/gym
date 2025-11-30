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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            $token = "zX8x2FOfZW203UptysmQsDccJHyQofZyrN6JWRSZc55qK6uBf6S7ZSdLkMq07YFN.afcch63i"; // Ganti dengan token Wablas yang valid
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

    public function get_otp_admin(Request $request)
    {
        $phone_number = $request->phone_number;
        $user_id = User::where('phone_number', $phone_number)->pluck('id')->first();
        $validator = Validator::make($request->only('phone_number'), [
            'phone_number' => ['required', 'string', 'min:10', 'max:13']
        ]);

        if ($validator->fails()) {
            $status = false;
            $message = $validator->errors()->all();
        }
        if ($user_id == null) {
            $status = false;
            $message = 'Phone number not found.';
        } elseif ($user_id != null) {
            $user_role = User::where('id', $user_id)->pluck('role')->first();
            if ($user_role != 'admin' && $user_role != 'personal trainer') {
                $status = false;
                $message = 'You are not authorized to use this login method.';
            } else {
                // Cek apakah device Wablas terhubung
                $deviceStatus = $this->checkDevice();
                
                if (!$deviceStatus) {
                    // Jika device Wablas tidak terhubung, beri alert
                    $status = false;
                    $message = 'WA disconnected, kasih tau admin.';
                } else {
                    // Jika perangkat terhubung, lanjutkan proses OTP
                    $otp = rand(1000, 9999);
                    $expired_at = now()->addMinutes(5)->setTimezone('Asia/Jakarta');
                    $insert_otp = DB::table('users')->where('id', $user_id)->update([
                        'otp' => $otp,
                        'otp_expired_at' => $expired_at,
                    ]);

                    // Mengirimkan pesan WA dan menangani response
                    $waResponse = $this->sendWA($phone_number, 'Flozors Gym: Gunakan kode OTP ' . $otp . ', UNTUK LOGIN KE AKUN ANDA. Berlaku selama 5 menit. JANGAN pernah membagikan kode ini kepada orang lain, termasuk staf Flozors Gym.');

                    if (!$waResponse['success']) {
                        // Jika device Wablas disconnect atau terjadi error, beri alert
                        $status = false;
                        $message = 'WA diskonek, sampaikan ke admin. Error: ' . $waResponse['message'];
                    }
                }
            }
        }

        $data = [
            'status' => $status ?? true,
            'message' => $message ?? 'OTP has been sent.',
            'data' => [
                'otp' => $otp ?? null,
                'wablas' => $waResponse['success'] ?? null,
            ]
        ];

        return response()->json($data, 200);
    }

    public function verify_otp_admin($phone_number)
    {
        return view('auth.verify-otp-admin', compact('phone_number'));
    }

    public function login_otp_admin(Request $request)
    {
        $phone_number = $request->phone_number;
        $otp = $request->otp;

        $validator = Validator::make($request->only('otp'), [
            'otp' => ['required', 'numeric', 'digits:4']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user_id = User::where('phone_number', $phone_number)->pluck('id')->first();
        $otp_exists = User::where('otp', $otp)
            ->where('id', $user_id)
            ->where('otp_expired_at', '>=', now()->setTimeZone('Asia/Jakarta'))
            ->first();

        if ($otp_exists == null) {
            return response()->json([
                'status' => false,
                'message' => 'OTP not found or expired.',
            ], 404);
        }

        if ($otp_exists != null && $user_id != null) {
            $user = User::find($user_id);
            $user_role = $user->role;
            
            // Verify role is admin or personal trainer
            if ($user_role != 'admin' && $user_role != 'personal trainer') {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to use this login method.',
                ], 403);
            }

            Auth::login($user);
            DB::table('users')->where('id', $user_id)->update([
                'otp' => null,
                'otp_expired_at' => null,
            ]);

            $redirectUrl = $user_role == 'admin' 
                ? route('admin_dashboard') 
                : route('personal_trainer.attendance_member');

            return response()->json([
                'status' => true,
                'message' => 'Login success.',
                'redirect' => $redirectUrl,
            ], 200);
        }
    }

    private function sendWA($mobileNumber, $message)
    {
        $url = "https://jogja.wablas.com";
        $token = "zX8x2FOfZW203UptysmQsDccJHyQofZyrN6JWRSZc55qK6uBf6S7ZSdLkMq07YFN.afcch63i";

        $client = new \GuzzleHttp\Client([
            'base_uri' => $url,
        ]);

        try {
            // Mengirim request ke API Wablas
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

            // Cek status dari API response
            if (isset($body['status']) && $body['status'] == true) {
                // Jika status sukses
                if ($response->getStatusCode() == 200) {
                    return ['success' => true];
                } else {
                    return ['success' => false, 'message' => 'WA connection failed'];
                }
            } else {
                // Jika Wablas memberikan error dalam response
                return ['success' => false, 'message' => $body['message'] ?? 'Unknown error'];
            }
        } catch (\Exception $e) {
            // Tangani jika terjadi error saat koneksi ke API Wablas (misalnya, device disconnect)
            return ['success' => false, 'message' => 'Device disconnected or API error'];
        }
    }

    private function checkDevice()
    {
        $phones = "6285184741788";
        $token = "zX8x2FOfZW203UptysmQsDccJHyQofZyrN6JWRSZc55qK6uBf6S7ZSdLkMq07YFN";
        $curl = curl_init();
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "url: https://jogja.wablas.com",
            )
        );
        curl_setopt($curl, CURLOPT_URL, "https://phone.wablas.com/check-phone-number?phones=$phones");
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        $response = json_decode($result, true);
        if (isset($response['status']) && $response['status'] === 'failed') {
            return false;
        }
        return true;
    }
}
