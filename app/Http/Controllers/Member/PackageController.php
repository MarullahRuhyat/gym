<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    public function package()
    {
        $package = DB::table('gym_membership_packages')->get();
        return view('member.membership.select-package', compact('package'));
    }

    public function subscribed_package()
    {
        $user = auth()->user();
        // $membership = DB::table('memberships')
        //     ->join('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
        //     ->where('memberships.user_id', $user->id)
        //     ->get();

        $membership_payments = DB::table('payments')
            ->join('memberships', 'payments.membership_id', '=', 'memberships.id')
            ->join('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('payments.user_id', $user->id)
            ->get();

        return view('member.membership.subscribed-package', compact('membership_payments'));
    }

    public function selected_package_detail($id)
    {
        $package = DB::table('gym_membership_packages')->where('id', $id)->first();
        return response()->json($package);
    }

}
