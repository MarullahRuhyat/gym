<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function send_otp()
    {
        return view('member.auth.send_otp');
    }

    public function get_otp(Request $request)
    {
        $phone_number = $request->phone_number;
        $user_id= User::where('phone_number', $phone_number)->pluck('id')->first();
        $validator = Validator::make($request->only('phone_number'), [
            'phone_number' => ['required', 'string', 'min:10', 'max:13']
        ]);

        if ($validator->fails()) {
            $status = false;
            $message = $validator->errors()->all();
        } if ($user_id == null) {
            $status = false;
            $message = 'Phone number not found.';
        } else {
            $otp = rand(1000, 9999);
            // $expired_at = now()->addMinutes(5);
            $expired_at = now()->addMinutes(5)->setTimezone('Asia/Jakarta');
            $insert_otp = DB::table('users')->where('id', $user_id)->update([
                'otp' => $otp,
                'otp_expired_at' => $expired_at,
            ]);
            // $send = new sendWA();
            // $curl = $send->send($phone_number, $otp);
        }

        $data = [
            'status' => $status ?? true,
            'message' => $message ?? 'OTP has been sent.',
            'data' => [
                'otp' => $otp ?? null,
                'wablas' => $curl ?? null,
            ]
        ];

        return response()->json($data, 200);
    }

    public function verify_otp($phone_number)
    {
        return view('member.auth.login');
    }

    public function login (Request $request)
    {
        $phone_number = $request->phone_number;
        $otp = $request->otp;
        $validator = Validator::make($request->only('otp'), [
            'otp' => ['required', 'numeric', 'digits:4']
        ]);

        if ($validator->fails()){
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

    // register

    public function register()
    {
        $package = DB::table('gym_membership_packages')->get();
        return view('member.auth.register', compact('package'));
    }

    public function store1(Request $request)
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

    public function register_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            // 'email' => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'min:10', 'unique:users,phone_number'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'start_date' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        if ($validator->fails()) {
            $status = false;
            $message = $validator->errors()->all();
        } else {
            $duration = DB::table('gym_membership_packages')->where('id', $request->package_id)->get('duration_in_days');
            $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $duration . ' days'));
            $user = User::create($request->all());
            $user_membership_packages = DB::table('memberships')->insert([
                'user_id' => $user->id,
                'gym_membership_packages' => $request->package_id,
                'start_date' => $request->start_date,
                'end_date' => $end_date,
                'is_active' => false,
            ]);
            $status = true;
            $message = 'Register success.';
        }

        $price = DB::table('gym_membership_packages')->where('id', $request->package_id)->pluck('price')->first();

        $data = [
            'status' => $status,
            'message' => $message,
            'data' => [
                'user' => $user ?? null,
                'gym_membership_packages_id' => $request->package_id ?? null,
                'price' => $price ?? null,
            ]
        ];

        return response()->json($data, 200);
    }

    // end register

    public function logout()
    {
        Auth::logout();
        return redirect()->route('member.send-otp');
    }
}
