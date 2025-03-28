<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPayroll;
use App\Models\GajiPersonalTrainer;
use App\Models\PersonalTrainingBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    //
    function index(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $bulan_gaji = $request->bulan_gaji;
                GajiPersonalTrainer::where(DB::raw('DATE_FORMAT(gaji_personal_trainers.bulan_gaji, "%Y-%m")'), $bulan_gaji)->update(['status' => 2]);
                return redirect()->route('admin_gaji')->with('success', 'Berhasil dikirim');
            } catch (\Throwable $th) {
                return redirect()->route('admin_gaji')->with('success', 'Gagal dikirim');
            }
        }

        $years = DB::table('gaji_personal_trainers')
            ->select(DB::raw('DATE_FORMAT(bulan_gaji, "%Y") as formatted_tahun_gaji'))
            ->distinct()
            ->orderBy(DB::raw('DATE_FORMAT(bulan_gaji, "%Y")'), 'desc')
            ->limit(5)
            ->get();

        $latestYear = DB::table('gaji_personal_trainers')
            ->select(DB::raw('DATE_FORMAT(bulan_gaji, "%Y") as formatted_tahun_gaji'))
            ->orderBy('bulan_gaji', 'desc')
            ->limit(1)
            ->pluck('formatted_tahun_gaji')
            ->first();

        $year = $request->query('year', $latestYear);

        $months = DB::table('gaji_personal_trainers')
            ->select(DB::raw('DATE_FORMAT(bulan_gaji, "%Y-%m") as formatted_bulan_gaji'))
            ->where(DB::raw('DATE_FORMAT(bulan_gaji, "%Y")'), $year)
            ->distinct()
            ->orderBy(DB::raw('DATE_FORMAT(bulan_gaji, "%Y-%m")'), 'desc')
            ->get();

        $latestMonth = DB::table('gaji_personal_trainers')
            ->select(DB::raw('DATE_FORMAT(bulan_gaji, "%Y-%m") as formatted_bulan_gaji'))
            ->where(DB::raw('DATE_FORMAT(bulan_gaji, "%Y")'), $year)
            ->orderBy('bulan_gaji', 'desc')
            ->limit(1)
            ->pluck('formatted_bulan_gaji')
            ->first();
        $perPage = 10;
        $page = $request->query('page', 1);
        $month = $request->query('month', $latestMonth);
        $name = $request->query('name', '');

        $gaji = GajiPersonalTrainer::select(
            'gaji_personal_trainers.id as id',
            DB::raw('SUM(b.amount) as total_bonus'),
            'u.name',
            'gaji_personal_trainers.salary as salary',
            'gaji_personal_trainers.status as status'
        )
            ->leftJoin('users as u', 'gaji_personal_trainers.personal_trainer_id', '=', 'u.id')
            ->leftJoin('personal_training_bonuses as b', 'gaji_personal_trainers.id', '=', 'b.gaji_personal_trainers_id')
            ->where(DB::raw('DATE_FORMAT(gaji_personal_trainers.bulan_gaji, "%Y-%m")'), $month)
            ->groupBy('gaji_personal_trainers.id', 'u.name', 'gaji_personal_trainers.salary', 'gaji_personal_trainers.status');

        if ($name != '') {
            $gaji->where('u.name', 'LIKE', '%' . $name . '%');
        }
        $results = $gaji->paginate($perPage, ['*'], 'page', $page);
        $total_page = intval(ceil($results->total() / $results->perPage()));

        if ($request->ajax()) {
            return view('admin.gaji.data', compact('results', 'total_page', 'month', 'months'))->render();
        }

        return view('admin.gaji.index', compact('results', 'total_page', 'month', 'months', 'year', 'years'));
    }

    function ajax_get_bonus(Request $request)
    {
        $gaji_id = $request->query('gaji_id');

        try {
            $bonus = PersonalTrainingBonus::where('gaji_personal_trainers_id', $gaji_id)->get();

            return response()->json([
                'status' => true,
                'data' => $bonus
            ]);

            // Do something with the validated data, e.g., save to the database


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memproses data',
            ]);
        }
    }

    function bonus(Request $request)
    {
        $month = $request->month;
        $gaji_id = $request->gaji_personal_trainers_id;
        $amounts = $request->amounts;
        $descriptions = $request->descriptions;

        $bonuses = PersonalTrainingBonus::where('gaji_personal_trainers_id', $gaji_id)->get();

        try {
            // Update existing bonuses
            foreach ($bonuses as $row) {
                $amount = $request->input('amount_' . $row->id);
                $description = $request->input('description_' . $row->id);

                if ($amount !== null && $description !== null) {
                    $amount = (int) str_replace('.', '', $amount);
                    $row->amount = $amount;
                    $row->description = $description;
                    $row->save();
                }
            }

            // Insert new bonuses
            $i = 0;
            if ($amounts != null) {
                foreach ($amounts as $row) {
                    $row = (int) str_replace('.', '', $row);
                    $bonus = new PersonalTrainingBonus();
                    $bonus->gaji_personal_trainers_id = $gaji_id;
                    $bonus->amount = $row;
                    $bonus->description = $descriptions[$i];
                    $bonus->save();
                    $i++;
                }
            }

            return redirect()->route('admin_gaji', [
                'month' => $month,
                'year' => explode("-", $month)[0],
            ])->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            \Log::error('Error Saving Bonus: ', ['error' => $th->getMessage()]);
            return redirect()->route('admin_gaji')->with('error', 'Data gagal disimpan!');
        }
    }


    function generate(Request $request)
    {
        // Ambil tanggal dari request
        $date = $request->input('date'); // Pastikan ini sesuai dengan nama field dalam request

        // Format tanggal sekarang
        $date_now = Carbon::today()->format('Y-m-d');
        $date_gaji = "{$date}-" . config('app.scheduler.payroll_date');
        $endDate = Carbon::createFromFormat('Y-m-d', $date_gaji)->subDay()->format('Y-m-d');
        $startDate = Carbon::createFromFormat('Y-m-d', $date_gaji)->subMonth()->format('Y-m-d');

        if (Carbon::parse($date_gaji)->gt($date_now)) {
            return redirect()->route('admin_gaji')->with('error', "Maaf untuk generate gaji bulan {$date} belum dapat dilakukan");
        } elseif (Carbon::parse($date_gaji)->lt($date_now)) {
            ProcessPayroll::dispatch($startDate, $endDate);
            return redirect()->route('admin_gaji')->with('success', "Generate gaji sedang di lakukan mohon tunggu beberapa saat lalu refresh web anda.");
        } else {
            ProcessPayroll::dispatch($startDate, $endDate);
            return redirect()->route('admin_gaji')->with('success', "Generate gaji sedang di lakukan mohon tunggu beberapa saat lalu refresh web anda.");
        }
    }
}
