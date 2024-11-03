<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PaymentCashController extends Controller
{
    public function index()
    {
            $data_cash = DB::table('payments')
                ->join('users', 'payments.user_id', '=', 'users.id')
                ->leftJoin('memberships', 'payments.membership_id', '=', 'memberships.id') // Menggunakan memberships
                ->select('payments.id as payment_id',
                        'payments.amount',
                        'payments.status',
                        'payments.payment_method',
                        'payments.created_at',
                        'users.name as user_name',
                        'users.id as user_id',
                        'users.phone_number as user_phone',
                        'memberships.id as id_membership',
                        'memberships.start_date as start_date',
                        'memberships.end_date as end_date',
                        )
                ->where('payments.status', 'pending')
                ->where('payments.payment_method', 'cash')
                ->get();
            return view('admin.payment_cash', ['data_cash' => $data_cash]);
    }

    public function cash_acc(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $membershipId = $request->input('id_membership');
        $userId = $request->input('user_id');
        $enddate = $request->input('end_date');
        $startdate = $request->input('start_date');
        $package_id = DB::table('memberships')->where('id', $membershipId)->pluck('gym_membership_packages')->first();

        // update end date dan personal trainer (gw nambah ini)
        // $personal_trainer_user = DB::table('users')->where('id', $userId)->pluck('available_personal_trainer_quota')->first();
        $personal_trainer_package = DB::table('gym_membership_packages')->where('id', $package_id)->pluck('personal_trainer_quota')->first();
        $user_terkait = DB::table('memberships')->where('id', $membershipId)->pluck('user_terkait')->first();
        // dd($personal_trainer_package);

        // strpos($user_terkait, '1') !== false
        if(strpos($user_terkait, '1') !== false){
            // $personal_trainer_user = $personal_trainer_user + $personal_trainer_package;
            DB::table('users')->where('id', $userId)->update([
                'end_date' => $enddate,
                'available_personal_trainer_quota' => $personal_trainer_package
            ]);
        } else {
            // $personal_trainer_user = $personal_trainer_user + $personal_trainer_package;
            DB::table('users')->where('id', $userId)->update([
                'end_date' => $enddate,
            ]);
        }
        //end

        // update start date
        $date = Carbon::now();

        DB::table('payments')
            ->where('id', $paymentId)
            ->update(['status' => 'paid']);

        $check_extend = DB::table('memberships')->where('user_id', $userId)->where('is_active', 1)->pluck('id')->toArray();
        if (count($check_extend) >= 1) {
            // dd($request->all());
            DB::table('memberships')->where('id', $membershipId)->update([
                'is_active' => 1
            ]);
            DB::table('memberships')->where('user_id', $userId)->where('id', '!=', $membershipId)->update([
                'is_active' => 0
            ]);
            // update end date users (gw nambah ini)
            DB::table('users')->where('id', $userId)->update([
                'end_date' => $enddate
            ]);
            // end

        } else {
            DB::table('memberships')
            ->where('id', $membershipId)
            ->update(['is_active' => 1]);
        }

        DB::table('users')
            ->where('id', $userId)
            ->update(['status' => 'active']);

        DB::table('users')
            ->where('id', $userId)
            ->update(['start_date' => $date]);

        DB::table('users')
            ->where('id', $userId)
            ->update(['end_date' => $enddate]);

        return redirect()->route('admin_cash')->with('success', 'Payment accepted successfully.');
    }

    public function cash_rej(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $membershipId = $request->input('membership_id');
        $userId = $request->input('user_id');

        // Update the payment status to 'REJECTED'
        DB::table('payments')
            ->where('id', $paymentId)
            ->update(['status' => 'expired']);

        return redirect()->route('admin_cash')->with('success', 'Payment rejected successfully.');
    }
}
