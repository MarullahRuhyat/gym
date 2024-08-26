<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Models\Membership;
use App\Http\Controllers\Controller;
use App\Models\GymMembershipPackage;

class PersonalTrainerController extends Controller
{
    public function dashboard()
    {
        $data = Membership::select('gym_membership_packages.name', \DB::raw('COUNT(memberships.id) as active_members'))
        ->join('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
        ->where('memberships.is_active', 1)
        ->groupBy('gym_membership_packages.name')
        ->get();

        // Memisahkan data untuk digunakan di chart
        $labels = $data->pluck('name');
        $series = $data->pluck('active_members');

        // Memisahkan data untuk digunakan di chart
        $labels = $data->pluck('name');
        $series = $data->pluck('active_members');

        return view('personal_training.dashboard', compact('labels', 'series'));
    }

    public function personal_trainer_dashboard()
    {
        $data = Membership::select('gym_membership_packages.name', \DB::raw('COUNT(memberships.id) as active_members'))
            ->join('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.is_active', 1)
            ->groupBy('gym_membership_packages.name')
            ->get();

        // Memisahkan data untuk digunakan di chart
        $labels = $data->pluck('name');
        $series = $data->pluck('active_members');

        // return json($labels, $series);
        return response()->json([
            'labels' => $labels,
            'series' => $series
        ]);

    }

}
