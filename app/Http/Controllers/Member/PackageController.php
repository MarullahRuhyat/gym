<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Member;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    public function package()
    {
        $package = DB::table('gym_membership_packages')->get();
        return view('member.membership.select-package', compact('package'));
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
<<<<<<< HEAD
            ->orderBy('payments.created_at', 'desc')
=======
            ->orderBy('payments.id', 'desc')
>>>>>>> 3b0f702 (chore: Order membership payments by ID in subscribed package view)
            ->get();

        return view('member.membership.subscribed-package', compact('packages_membership_payments'));
    }

    public function selected_package_detail($id)
    {
        $package = DB::table('gym_membership_packages')->where('id', $id)->first();
        return response()->json($package);
    }

}
