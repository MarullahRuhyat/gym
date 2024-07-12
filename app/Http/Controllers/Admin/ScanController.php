<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsentMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    function index(Request $request)
    {
        $personal_trainers = User::where('role', 'personal trainer')->where('status', 'active')->get();
        return view('admin.scan', compact('personal_trainers'));
    }

    function post_attendance(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string|max:255',
        ]);
        try {
            $qr_code = $request->qr_code;
            $absen = AbsentMember::with('member')->where('qr_code', $qr_code)->first();
            if ($absen) {
                if ($absen->start_time == null || $absen->start_time == '') {
                    $absen->start_time = Carbon::now();
                    $absen->save();
                } elseif ($absen->start_time != null  && ($absen->end_time == null || $absen->start_time == '')) {
                    $absen->end_time = Carbon::now();
                    $absen->save();
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'QR sudah digunakan',
                        'qr' => $request->qr_code,
                        'absen' => $absen
                    ]);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil Proses',
                    'qr' => $request->qr_code,
                    'absen' => $absen,
                    'time' => config('app.timezone')
                ]);
            }

            // Do something with the validated data, e.g., save to the database

            return response()->json([
                'status' => false,
                'message' => 'QR tidak ditemukan',
                'qr' => $request->qr_code,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memproses data',
                'qr' => $request->qr_code,
            ]);
        }
    }
}
