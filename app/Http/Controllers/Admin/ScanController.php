<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsentMember;
use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    function index(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $pt = $request->input('pt', null);
                $absent = AbsentMember::findOrFail($request->id);
                if ($absent->end_time == null && $pt != null) {
                    $absent->personal_trainer_id = $pt;
                    $absent->save();
                    $membersip = Membership::where('user_id', $absent->member_id)->select('user_terkait')->first();
                    $user_terkait = array_map('intval', explode(',', $membersip->user_terkait));
                    User::whereIn('id',  $user_terkait)->decrement('available_personal_trainer_quota', 1);
                }
                return redirect()->route('admin_scan')->with('success', 'Data berhasil disimpan!');
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('admin_scan')->with('error', 'Gagal menambah personal trainer!');
            }
        }
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
            $absen = AbsentMember::with('member')
                ->where('qr_code', $qr_code)
                ->where('end_time', null)
                ->first();
            if ($absen) {
                if ($absen->start_time == null || $absen->start_time == '') {
                    $absen->start_time = Carbon::now();
                    $absen->date = Carbon::now()->format('Y-m-d');
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
                $user = null;
                if ($absen->is_using_pt == 1) {
                    $membersip = Membership::where('user_id', $absen->member_id)->select('user_terkait')->first();
                    $user_terkait = array_map('intval', explode(',', $membersip->user_terkait));
                    $user = User::whereIn('id',  $user_terkait)->select('name')->get();
                }

                // Do something with the validated data, e.g., save to the database
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil Proses',
                    'qr' => $request->qr_code,
                    'absen' => $absen,
                    'time' => config('app.timezone'),
                    'user' => $user
                ]);
            }

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
