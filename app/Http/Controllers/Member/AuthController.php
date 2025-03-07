<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Helper\sendNotif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function send_otp()
    {
        return view('member.auth.send_otp');
    }

    public function get_otp(Request $request)
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
        } elseif ($user_id != null && User::where('id', $user_id)->pluck('role')->first() != 'member') {
            $status = false;
            $message = 'Your Not member';
        } else {
            // Cek apakah device Wablas terhubung
            $deviceStatus = $this->checkDevice();
            
            if (!$deviceStatus) {
                // Jika device Wablas tidak terhubung, beri alert
                $status = false;
                $message = 'WA disconnected, kasih tau admin.';
            }

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


    public function verify_otp($phone_number)
    {
        return view('member.auth.login');
    }

    public function login(Request $request)
    {
        $phone_number = $request->phone_number;
        $otp = $request->otp;

        $validator = Validator::make($request->only('otp'), [
            'otp' => ['required', 'numeric', 'digits:4']
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
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
            Auth::login($user);
            DB::table('users')->where('id', $user_id)->update([
                'otp' => null,
                'otp_expired_at' => null,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Login success.',
            ], 200);
        }
    }

    // only register - single user
    public function register()
    {
        $package = DB::table('gym_membership_packages')->get();
        return view('member.auth.register_or_select_package', compact('package'));
    }

    public function register_form()
    {
        return view('member.auth.register-form');
    }

    public function register_form_process(Request $request)
    {
        // check phone number is unique
        $validator = Validator::make($request->all(), [
            'phone_number' => ['required', 'unique:users,phone_number'],
        ], [
            'phone_number.unique' => 'Nomor telepon sudah digunakan, silakan gunakan nomor lain.',
            'phone_number.required' => 'Nomor telepon wajib diisi.'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $save = User::create($request->except('password_confirmation'));
        return redirect()->route('member.send-otp')->with('success', 'Register success.');

    }

    // register multiple user
    public function register_multi_user_get_package()
    {
        $packages = DB::table('gym_membership_packages')
            ->leftJoin('type_packages', 'gym_membership_packages.type_packages_id', '=', 'type_packages.id')
            ->select('gym_membership_packages.*', 'type_packages.name as type_name')
            ->get();

        $groupedPackages = $packages->groupBy('type_name');
        return view('member.auth.register_multi_user', compact('groupedPackages'));
    }

    public function get_package_detail(Request $request)
    {
        $package_id = $request->package_id;
        $package = DB::table('gym_membership_packages')->where('id', $package_id)->get();
        $data = [
            'status' => true,
            'message' => 'Package has been selected.',
            'data' => [
                'package' => $package
            ],
        ];
        return response()->json($data);
    }

    public function check_member_terkait(Request $request)
    {
        // cek status user_registered (unregistered, expired, active)
        $phone_number = $request->form_dynamic;
        $user_registered = User::whereIn('phone_number', $phone_number)->get(); // ini harus di cek semua phone number yang di inputkan
        if ($user_registered == null) {
            $user_registered = [];
        }

        // check user_registered length same with phone_number length
        if (count($phone_number) != count($user_registered)) {
            $status = false;
            $message = 'Phone number not found, check again.';
        } else {
            $user_terkait = User::whereIn('phone_number', $phone_number)->pluck('id');
            if ($user_registered != null) {
                $validator = Validator::make($request->form_first, [
                    'name' => ['required', 'string', 'min:3', 'max:255'],
                    // 'phone_number' => ['required', 'string', 'min:10', 'unique:users,phone_number'],
                    'address' => ['required', 'string', 'min:3', 'max:255'],
                    // 'password' => ['required', 'string', 'min:8', 'max:255'],
                ]);

                if ($validator->fails()) {
                    $status = false;
                    $message = $validator->errors()->all();
                } else {
                    // DB::table('users')->insert($request->form_first);
                    // if in table users found (update data), else (insert data)
                    $user = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->first();
                    if ($user != null) {
                        // $update = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->update($request->form_first);
                        $update = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->update([
                            'name' => $request->form_first['name'],
                            'phone_number' => $request->form_first['phone_number'],
                            'address' => $request->form_first['address'],
                            'password' => bcrypt($request->form_first['password']),
                            'status' => 'unregistered',
                            'updated_at' => now(),
                        ]);
                    } else {
                        // $insert = DB::table('users')->insert($request->form_first);
                        // insert all with hash password and created_at, updated_at
                        $insert = DB::table('users')->insert([
                            'name' => $request->form_first['name'],
                            'phone_number' => $request->form_first['phone_number'],
                            'address' => $request->form_first['address'],
                            'password' => bcrypt($request->form_first['password']),
                            'status' => 'unregistered',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    $duration = DB::table('gym_membership_packages')->where('id', $request->package_id)->pluck('duration_in_days')->first();
                    $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $duration . ' days'));
                    $user_id = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->pluck('id')->first();
                    $user_membership_packages = DB::table('memberships')->insert([
                        'user_id' => DB::table('users')->where('phone_number', $request->form_first['phone_number'])->pluck('id')->first(),
                        'gym_membership_packages' => $request->package_id,
                        'start_date' => $request->start_date,
                        'end_date' => $end_date,
                        // 'user_terkait' => $user_terkait,
                        // 'user_terkait' => implode(',', $user_terkait->toArray()),
                        // user_terkait + user_id
                        'user_terkait' => $user_id . ',' . implode(',', $user_terkait->toArray()),
                        'duration_in_days' => $duration,
                        'is_active' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // save all user_registered to memberships in each row
                    foreach ($user_registered as $user) {
                        $user_membership_packages = DB::table('memberships')->insert([
                            'user_id' => $user->id,
                            'gym_membership_packages' => $request->package_id,
                            'start_date' => $request->start_date,
                            'end_date' => $end_date,
                            'user_terkait' => $user_id . ',' . implode(',', $user_terkait->toArray()),
                            'duration_in_days' => $duration,
                            'is_active' => false,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    // update end_date using duration_in_days for each user_registered
                    foreach ($user_registered as $user) {
                        $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $duration . ' days'));
                        DB::table('users')->where('id', $user->id)->update([
                            'end_date' => $end_date,
                        ]);
                    }
                    // also update end_date for user_id
                    DB::table('users')->where('id', $user_id)->update([
                        'end_date' => $end_date,
                    ]);

                    $status = true;
                    $message = 'Register success.';
                }
            } else {
                $status = false;
                $message = 'Phone number not found.';
            }
        }

        $amount_package = DB::table('gym_membership_packages')->where('id', $request->package_id)->pluck('price')->first();

        $user_dynamic_status = DB::table('users')->whereIn('phone_number', $phone_number)->pluck('status')->toArray();
        $fee = 75000;
        foreach ($user_dynamic_status as $status_dynamic) {
            if ($status_dynamic == 'unregistered' || $status_dynamic == 'expired') {
                $fee += 75000;
            }
        }

        $data = [
            'status' => $status,
            'message' => $message,
            'data' => [
                'user' => $user_registered,
                'user_phone_number' => $request->form_first['phone_number'],
                // 'user_registered' => (count($user_registered) + 1) * 75000,
                'user_registered' => $fee,
                'payment_item_total' => $amount_package,
                // 'total' => ((count($user_registered) + 1) * 75000) + $amount_package,
                'total' => $fee + $amount_package,
            ],
        ];


        return response()->json($data);
    }

    public function register__multi_user_submit(Request $request)
    {
        dd($request->all());
    }

    // end register

    public function logout()
    {
        Auth::logout();
        return redirect()->route('member.send-otp');
    }

    public function withPassword(Request $request)
    {
        $phone_number = $request->cookie('phone_number');
        $password = $request->cookie('password');
        $remember = $request->cookie('remember_me');
        if ($remember == '1') {
            $remember = $request->has('remember_me');
        }
        return view('member.auth.loginpassword', compact('phone_number', 'password', 'remember'));
    }

    public function login_with_password(Request $request)
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
            return redirect()->route('member.dashboard');
        }
        return redirect()->back()->with('error', 'The provided credentials do not match our records.');
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
            $message = "Your OTP code is: https://flozorsgym.com/member/verify-otp?otp=$otp .This code will expire in 10 minutes.";

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

            return redirect()->route('member.with_password')->with('success', 'Password has been reset. Please login with your new password.');
        }

        return redirect()->back()->with('error', 'Failed to reset password. OTP is invalid or has expired.');

    }

    public function testabsenttime()
    {
        $time = Carbon::now()->format('H:i:s');
        $today = Carbon::today();

        DB::table('absent_members')
            ->whereNull('date')
            ->update([
                'date' => $today,
            ]);

        DB::table('absent_members')
            ->whereNotNull('date')
            ->whereNull('start_time')
            ->update([
                'start_time' => $time,
            ]);

        DB::table('absent_members')
            ->whereNotNull('date')
            ->whereNotNull('start_time')
            ->whereNull('end_time')
            ->update([
                'end_time' => $time,
            ]);
    }
}
