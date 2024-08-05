<?php

namespace App\Jobs;

use App\Models\AbsentMember;
use App\Models\GajiPersonalTrainer;
use App\Models\PersonalTrainingBonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessPayroll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startDate = Carbon::today()->subMonth()->format('Y-m-d');
        $endDate = Carbon::today()->subDay()->format('Y-m-d');
        $users = User::select('id', 'salary_pt')->where('role', 'personal trainer')->get();
        foreach ($users as $user) {
            $gaji = new GajiPersonalTrainer();
            $gaji->salary = $user->salary_pt;
            $gaji->personal_trainer_id = $user->id;
            $gaji->bulan_gaji = Carbon::now();
            $gaji->status = 1;
            $gaji->save();

            $absents = AbsentMember::select(
                'type_packages.name as package_name',
                DB::raw('COUNT(absent_members.type_packages_id) as type_count')
            )
                ->leftJoin('users', 'absent_members.personal_trainer_id', '=', 'users.id')
                ->leftJoin('type_packages', 'type_packages.id', '=', 'absent_members.type_packages_id')
                ->where('absent_members.personal_trainer_id', $user->id)
                ->whereBetween('absent_members.date', [$startDate, $endDate])
                ->groupBy('users.id', 'type_packages.id')
                ->orderBy('type_packages.id')
                ->get();
            foreach ($absents as $absent) {
                $bonus = new PersonalTrainingBonus();
                $bonus->description = $absent->package_name . ' (' . $absent->type_count . ')';
                $bonus->amount = 0;
                $bonus->gaji_personal_trainers_id = $gaji->id;
                $bonus->save();
            }
        }
    }
}
