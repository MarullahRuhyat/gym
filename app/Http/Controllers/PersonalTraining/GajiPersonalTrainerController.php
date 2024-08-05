<?php

namespace App\Http\Controllers\PersonalTraining;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GajiPersonalTrainerController extends Controller
{
    public function index() {
        $user = auth()->user();
        $bonus = DB::table('gaji_personal_trainers')
            ->join('personal_training_bonuses', 'gaji_personal_trainers.id', '=', 'personal_training_bonuses.gaji_personal_trainers_id')
            ->where('gaji_personal_trainers.personal_trainer_id', $user->id)
            ->get();
        $gaji_pokok = DB::table('gaji_personal_trainers')
            ->where('personal_trainer_id', $user->id)
            ->select('salary')
            ->first();
        // kalkulasi seluruh gaji 
        $bonus_sum = $bonus->sum('amount');
        $gaji_pokok_total = $gaji_pokok->salary;
        $total = $bonus_sum + $gaji_pokok_total;

        return view('personal_training.payment', compact('user', 'bonus', 'gaji_pokok', 'total'));
    }
}
