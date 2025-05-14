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
                        'memberships.user_terkait as user_terkait',
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
    
        // Ambil membership terakhir yang aktif untuk user ini
        $last_active_membership = DB::table('memberships')
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->orderBy('end_date', 'desc')
            ->first();
    
        // Jika membership terakhir ada, kita gunakan start_date dan end_date-nya untuk yang baru
        if ($last_active_membership) {
            $startdate = $last_active_membership->end_date; // Gunakan end_date dari membership terakhir
            $enddate = Carbon::parse($startdate)->addDays($last_active_membership->duration_in_days); // Hitung end_date baru berdasarkan durasi
        }
    
        $personal_trainer_user = DB::table('users')->where('id', $userId)->pluck('available_personal_trainer_quota')->first();
        $personal_trainer_package = DB::table('gym_membership_packages')->where('id', $package_id)->pluck('personal_trainer_quota')->first();
        $user_terkait = DB::table('memberships')->where('id', $membershipId)->pluck('user_terkait')->first();
        $check_extend = DB::table('memberships')->where('user_id', $userId)->where('is_active', 1)->pluck('id')->toArray();
    
        // Jika membership baru, kita update data user sesuai dengan membership terakhir
        if (count($check_extend) == 0) {
            if (strpos($user_terkait, '1') !== false) {
                $personal_trainer_user = $personal_trainer_package;
                DB::table('users')->where('id', $userId)->update([
                    'end_date' => $enddate,
                    'available_personal_trainer_quota' => $personal_trainer_user
                ]);
            } else {
                $personal_trainer_user = $personal_trainer_package;
                DB::table('users')->where('id', $userId)->update([
                    'end_date' => $enddate,
                    'available_personal_trainer_quota' => $personal_trainer_user
                ]);
            }
        } else {
            // Jika extend, kita hanya update end date dan is_active
            DB::table('memberships')->where('id', $membershipId)->update([
                'end_date' => $enddate,
                'is_active' => 1
            ]);
        }
    
        // Update status pembayaran
        DB::table('payments')->where('id', $paymentId)->update(['status' => 'paid']);
    
        // Jika extend, kita perbarui membership yang lain jadi non-aktif
        if (count($check_extend) >= 1) {
            DB::table('memberships')->where('id', $membershipId)->update([
                'is_active' => 1
            ]);
            DB::table('memberships')->where('user_id', $userId)->where('id', '!=', $membershipId)->update([
                'is_active' => 0
            ]);
            // Update end date users
            DB::table('users')->where('id', $userId)->update([
                'end_date' => $enddate
            ]);
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
            ->update(['start_date' => Carbon::now()]);
    
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