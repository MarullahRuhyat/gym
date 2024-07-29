<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessSalary;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardAdminController extends Controller
{
    //
    function index(Request $request)
    {
        return view('admin.test');
    }

    function ajax_dashboard_admin(Request $request)
    {
        $year = $request->input('year', date('Y'));
        // Query untuk menghitung 'active' dan 'inactive' pada 'member'
        $memberStatusCounts = DB::table('users')
            ->selectRaw("
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive
            ")
            ->where('role', 'member')
            ->first();

        // Query untuk menghitung 'active' dan 'inactive' pada 'personal trainer'
        $trainerStatusCounts = DB::table('users')
            ->selectRaw("
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive
            ")
            ->where('role', 'personal trainer')
            ->first();



        $absent = DB::table(DB::raw("
            (SELECT DISTINCT YEAR(date) AS tahun FROM absent_members WHERE YEAR(date) = $year) AS tahun
        "))
            ->crossJoin(DB::raw("
            (SELECT 'Januari' AS bulan, 1 AS urutan
             UNION SELECT 'Februari', 2
             UNION SELECT 'Maret', 3
             UNION SELECT 'April', 4
             UNION SELECT 'Mei', 5
             UNION SELECT 'Juni', 6
             UNION SELECT 'Juli', 7
             UNION SELECT 'Agustus', 8
             UNION SELECT 'September', 9
             UNION SELECT 'Oktober', 10
             UNION SELECT 'November', 11
             UNION SELECT 'Desember', 12) AS bulan
        "))
            ->leftJoin('absent_members as am', function ($join) {
                $join->on(DB::raw('YEAR(am.date)'), '=', 'tahun.tahun')
                    ->on(DB::raw('MONTH(am.date)'), '=', 'bulan.urutan');
            })
            ->selectRaw('tahun.tahun AS tahun, bulan.bulan AS bulan, COALESCE(COUNT(am.id), 0) AS jumlah_latihan')
            ->groupBy('tahun.tahun', 'bulan.bulan', 'bulan.urutan')
            ->orderBy('tahun.tahun', 'asc')
            ->orderBy('bulan.urutan', 'asc')
            ->get();

        // Mengakses hasil query
        $memberStatus = [
            'active' => $memberStatusCounts->active,
            'inactive' => $memberStatusCounts->inactive
        ];

        $trainerStatus = [
            'active' => $trainerStatusCounts->active,
            'inactive' => $trainerStatusCounts->inactive
        ];

        // Mengembalikan respon dalam bentuk JSON
        return response()->json([
            'memberStatus' => $memberStatus,
            'trainerStatus' => $trainerStatus,
            'absent' => $absent,
        ]);
    }
}
