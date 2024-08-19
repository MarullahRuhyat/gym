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
    protected $startDate;
    protected $endDate;

    /**
     * Create a new job instance.
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select('id', 'salary_pt')
            ->where('role', 'personal trainer')
            ->where('status', 'active')
            ->get();

        foreach ($users as $user) {
            $bulan = Carbon::createFromFormat('Y-m-d', $this->endDate)->format('Y-m');
            $check_gaji = GajiPersonalTrainer::where('personal_trainer_id', $user->id)
                ->where(DB::raw('DATE_FORMAT(bulan_gaji, "%Y-%m")'), $bulan)->first();
            if (!$check_gaji) {
                # code...
                $gaji = new GajiPersonalTrainer();
                $gaji->salary = $user->salary_pt;
                $gaji->personal_trainer_id = $user->id;
                $gaji->bulan_gaji = $this->endDate;
                $gaji->status = 1;
                $gaji->save();

                $absents = AbsentMember::select(
                    'type_packages.bonus as bonus',
                    'type_packages.name as package_name',
                    DB::raw('COUNT(absent_members.type_packages_id) as type_count')
                )
                    ->leftJoin('users', 'absent_members.personal_trainer_id', '=', 'users.id')
                    ->leftJoin('type_packages', 'type_packages.id', '=', 'absent_members.type_packages_id')
                    ->where('absent_members.personal_trainer_id', $user->id)
                    ->whereBetween('absent_members.date', [$this->startDate, $this->endDate])
                    ->groupBy('users.id', 'type_packages.id')
                    ->orderBy('type_packages.id')
                    ->get();

                foreach ($absents as $absent) {
                    $bonus = new PersonalTrainingBonus();
                    $bonus->description = $absent->package_name . ' (' . $absent->type_count . ')';
                    $bonus->amount = intval($absent->type_count) * intval($absent->bonus);
                    $bonus->gaji_personal_trainers_id = $gaji->id;
                    $bonus->save();
                }
            }
        }
    }
}
