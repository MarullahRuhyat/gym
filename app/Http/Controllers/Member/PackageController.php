<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Http\Middleware\Member;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

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

    public function buy_new_package()
    {
        $packages = DB::table('gym_membership_packages')
        ->leftJoin('type_packages', 'gym_membership_packages.type_packages_id', '=', 'type_packages.id')
        ->select('gym_membership_packages.*', 'type_packages.name as type_name')
        ->get();

        $groupedPackages = $packages->groupBy('type_name');

        return view('member.membership.buy-new-membership', compact('groupedPackages'));
    }

    public function submit_buy_new_package(Request $request)
    {

    }

    public function submit_package(Request $request)
    {
        $personal_trainer_in_table_user_first = DB::table('users')->where('phone_number', $request->form_first['phone_number'])->pluck('available_personal_trainer_quota')->first();
        $personal_trainer_in_table_user_registered = DB::table('users')->whereIn('phone_number', $request->form_dynamic)->pluck('available_personal_trainer_quota')->first();
        $personal_trainer_quota_from_membership = DB::table('gym_membership_packages')->where('id', $request->package_id)->pluck('personal_trainer_quota')->first();
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
                    'user_id' => $user_id,
                    'gym_membership_packages' => $request->package_id,
                    'start_date' => $request->start_date,
                    'end_date' => $end_date,
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

                DB::table('memberships')->where('user_id', $user_id)->update([
                    'is_active' => 0,
                ]);

                // update end_date using duration_in_days for each user_registered
                foreach ($user_registered as $user) {
                    $end_date = date('Y-m-d', strtotime($request->start_date . ' + ' . $duration . ' days'));
                    DB::table('users')->where('id', $user->id)->update([
                        'end_date' => $end_date,
                        'available_personal_trainer_quota' => $personal_trainer_quota_from_membership + $personal_trainer_in_table_user_registered,
                    ]);
                }
                // also update end_date for user_id
                DB::table('users')->where('id', $user_id)->update([
                    'end_date' => $end_date,
                    'available_personal_trainer_quota' => $personal_trainer_quota_from_membership + $personal_trainer_in_table_user_first,
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
                'user_registered' => $fee,
                'payment_item_total' => $amount_package,
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

        $get_available_personal_trainer_quota = DB::table('users')->where('id', $user->id)->pluck('available_personal_trainer_quota')->first();

        $packages_membership_payments->transform(function ($item) use ($get_available_personal_trainer_quota) {
            if ($item->start_date && $item->end_date) {
                $startDate = Carbon::parse($item->start_date);
                $endDate = Carbon::parse($item->end_date);
                $item->duration_in_days = (int) $startDate->diffInDays($endDate);
                $item->available_personal_trainer_quota = $get_available_personal_trainer_quota;
            } else {
                $item->duration_in_days = null; // Jika tanggal tidak ada, beri nilai null
            }
            return $item;
        });

        return view('member.membership.subscribed-package', compact('packages_membership_payments'));
    }

    public function selected_package_detail($id)
    {
        $package = DB::table('gym_membership_packages')->where('id', $id)->first();
        return response()->json($package);
    }

}
