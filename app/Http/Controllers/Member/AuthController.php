<?php

namespace App\Http\Controllers\Member;

use App\Helper\sendNotif;
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
            $send = new sendNotif();
            $curl = $send->sendWA($phone_number,'Flozors Gym: Gunakan kode OTP ' . $otp . ', UNTUK LOGIN KE AKUN ANDA. Berlaku selama 5 menit. JANGAN pernah membagikan kode ini kepada orang lain, termasuk staf Flozors Gym.');
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
        if($user_registered == null) {
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
                    'phone_number' => ['required', 'string', 'min:10', 'unique:users,phone_number'],
                    'address' => ['required', 'string', 'min:3', 'max:255'],
                    'password' => ['required', 'string', 'min:8', 'max:255'],
                ]);

                if ($validator->fails()) {
                    $status = false;
                    $message = $validator->errors()->all();
                } else {
                    DB::table('users')->insert($request->form_first);
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
                $message =  'Phone number not found.';
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
}
