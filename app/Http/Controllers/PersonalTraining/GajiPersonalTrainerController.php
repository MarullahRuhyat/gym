<?php

namespace App\Http\Controllers\PersonalTraining;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GajiPersonalTrainerController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        // Mendapatkan rentang tanggal dari 25 bulan lalu hingga akhir bulan ini
        $startDate = Carbon::now()->subDays(25)->startOfMonth();
        $endDate = Carbon::now()->endOfDay();

        // Query untuk mendapatkan bonus
        $bonus = DB::table('gaji_personal_trainers')
            ->join('personal_training_bonuses', 'gaji_personal_trainers.id', '=', 'personal_training_bonuses.gaji_personal_trainers_id')
            ->where('gaji_personal_trainers.personal_trainer_id', $user->id)
            ->whereBetween('gaji_personal_trainers.bulan_gaji', [$startDate, $endDate])
            ->get();

        // Query untuk mendapatkan gaji pokok
        $gaji_pokok = DB::table('gaji_personal_trainers')
            ->where('personal_trainer_id', $user->id)
            ->whereBetween('gaji_personal_trainers.bulan_gaji', [$startDate, $endDate])
            ->select('salary', 'bulan_gaji')
            ->first();

        if ($bonus) {
            $bonus_sum = $bonus->sum('amount');
        } else {
            $bonus = 0;
        }

        if ($gaji_pokok) {
            $gaji_pokok_salary = $gaji_pokok->salary;
            $gaji_pokok_tanggal = $gaji_pokok->bulan_gaji;
            $gaji_pokok_tanggal = Carbon::parse($gaji_pokok_tanggal)->translatedFormat('d-F-Y');

        } else {
            $gaji_pokok = 0;
            $gaji_pokok_salary = 0;
            $gaji_pokok_tanggal = 0;
        }

        // dd($bonus, $gaji_pokok);
        $bonus_sum = $bonus->sum('amount');
        $gaji_pokok_total = $gaji_pokok_salary;
        $total = $bonus_sum + $gaji_pokok_total;


        return view('personal_training.payment', compact('user', 'bonus', 'gaji_pokok_salary', 'gaji_pokok_tanggal', 'total'));
    }
    public function search(Request $request)
    {
        $user = auth()->user();

        // Mengambil tanggal dari request dan mengkonversinya ke format yang sesuai
        $selectedDate = Carbon::createFromFormat('Y-m-d', $request->input('date'));

        // Mendapatkan rentang tanggal untuk pencarian
        $startDate = $selectedDate->startOfDay();
        $endDate = $selectedDate->endOfDay();

        // Query untuk mendapatkan bonus
        $bonus = DB::table('gaji_personal_trainers')
            ->join('personal_training_bonuses', 'gaji_personal_trainers.id', '=', 'personal_training_bonuses.gaji_personal_trainers_id')
            ->where('gaji_personal_trainers.personal_trainer_id', $user->id)
            ->whereBetween('gaji_personal_trainers.bulan_gaji', [$startDate, $endDate])
            ->get();

        // Query untuk mendapatkan gaji pokok
        $gaji_pokok = DB::table('gaji_personal_trainers')
            ->where('personal_trainer_id', $user->id)
            ->whereBetween('gaji_personal_trainers.bulan_gaji', [$startDate, $endDate])
            ->select('salary', 'bulan_gaji')
            ->first();

        if ($bonus) {
            $bonus_sum = $bonus->sum('amount');
        } else {
            $bonus = 0;
        }

        if ($gaji_pokok) {
            $gaji_pokok_salary = $gaji_pokok->salary;
            $gaji_pokok_tanggal = $gaji_pokok->bulan_gaji;
            $gaji_pokok_tanggal = Carbon::parse($gaji_pokok_tanggal)->translatedFormat('d-F-Y');
        } else {
            $gaji_pokok = 0;
            $gaji_pokok_salary = 0;
            $gaji_pokok_tanggal = 0;
        }

        $bonus_sum = $bonus->sum('amount');
        $gaji_pokok_total = $gaji_pokok_salary;
        $total = $bonus_sum + $gaji_pokok_total;

        return view('personal_training.payment', compact('user', 'bonus', 'gaji_pokok_salary', 'gaji_pokok_tanggal', 'total'));
    }

}
