<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Member;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function package_register()
    {
        $packages = DB::table('gym_membership_packages')
            ->leftJoin('type_packages', 'gym_membership_packages.type_packages_id', '=', 'type_packages.id')
            ->select('gym_membership_packages.*', 'type_packages.name as type_name')
            ->get();

        $groupedPackages = $packages->groupBy('type_name');

        return view('member.membership.select-package', compact('groupedPackages'));
    }

    public function package()
    {
        $packages = DB::table('gym_membership_packages')
        ->leftJoin('type_packages', 'gym_membership_packages.type_packages_id', '=', 'type_packages.id')
        ->select('gym_membership_packages.*', 'type_packages.name as type_name')
        ->get();

        $groupedPackages = $packages->groupBy('type_name');

        return view('member.membership.select-package', compact('groupedPackages'));
    }

    public function submit_package(Request $request)
    {
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
                $duration = DB::table('gym_membership_packages')->where('id', $request->package_id)->pluck('duration_in_days')->first();
                $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $duration . ' days'));
                $user_id = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->pluck('id')->first();
                $user_membership_packages = DB::table('memberships')->insert([
                    'user_id' => DB::table('users')->where('phone_number', $request->form_first['phone_number'])->pluck('id')->first(),
                    'gym_membership_packages' => $request->package_id,
                    'start_date' => $request->start_date,
                    'end_date' => $end_date,
                    'user_terkait' => $user_id . ',' . implode(',', $user_terkait->toArray()),
                    'duration_in_days' => $duration,
                    'is_active' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $status = true;
                $message = 'Register success.';
            } else {
                $status = false;
                $message =  'Phone number not found.';
            }
        }

        $amount_package = DB::table('gym_membership_packages')->where('id', $request->package_id)->pluck('price')->first();

        $user_first_status = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->pluck('status')->first();
        $user_dynamic_status = DB::table('users')->whereIn('phone_number', $phone_number)->pluck('status')->toArray();
        $fee = 0;
        if ($user_first_status == 'unregistered' || $user_first_status == 'expired') {
            $fee = 75000;
            foreach ($user_dynamic_status as $status_dynamic) {
                if ($status_dynamic == 'unregistered' || $status_dynamic == 'expired') {
                    $fee += 75000;
                }
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
                // 'total' => ((count($user_registered) + 1) * 75000) + $amount_package + $fee,
                'total' => $fee + $amount_package,
            ],
        ];

        return response()->json($data);
    }

    public function subscribed_package()
    {
        // cari user yang login
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('member.send-otp');
        }

        $packages_membership_payments = DB::table('payments')
            ->leftjoin('gym_membership_packages', 'payments.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->leftjoin('memberships', 'payments.membership_id', '=', 'memberships.id')
            ->where('payments.user_id', $user->id)
            ->orderBy('payments.id', 'desc')
            ->get();
            // dd($packages_membership_payments);

        return view('member.membership.subscribed-package', compact('packages_membership_payments'));
    }

    public function selected_package_detail($id)
    {
        $package = DB::table('gym_membership_packages')->where('id', $id)->first();
        return response()->json($package);
    }

}
