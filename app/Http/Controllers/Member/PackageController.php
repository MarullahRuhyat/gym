<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Http\Middleware\Member;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function package()
    {
        $packages = DB::table('gym_membership_packages')
            ->leftJoin('type_packages', 'gym_membership_packages.type_packages_id', '=', 'type_packages.id')
            ->select('gym_membership_packages.*', 'type_packages.name as type_name')
            ->get();

        $groupedPackages = $packages->groupBy('type_name');

        return view('member.membership.select-package', compact('groupedPackages'));
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

        $packages_membership_payments->transform(function ($item) {
            if ($item->start_date && $item->end_date) {
                $startDate = Carbon::parse($item->start_date);
                $endDate = Carbon::parse($item->end_date);
                $item->duration_in_days = (int) $startDate->diffInDays($endDate);
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
