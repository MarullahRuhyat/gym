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
                    $membersip = Membership::where('user_id', $absent->member_id)->where('is_active', 1)->select('user_terkait')->first();
                    $user_terkait = array_map('intval', explode(',', $membersip->user_terkait));
                    User::whereIn('id', $user_terkait)->decrement('available_personal_trainer_quota', 1);
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
            $absent = AbsentMember::with('member')
                ->where('qr_code', $qr_code)
                ->where('end_time', null)
                ->first();
            if ($absent) {
                if ($absent->start_time == null || $absent->start_time == '') {
                    $absent->start_time = Carbon::now();
                    $absent->date = Carbon::now()->format('Y-m-d');
                    $absent->save();
                } elseif ($absent->start_time != null && ($absent->end_time == null || $absent->start_time == '')) {
                    $absent->end_time = Carbon::now();
                    $absent->save();
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'QR sudah digunakan',
                        'qr' => $request->qr_code,
                        'absen' => $absent
                    ]);
                }
                $user = null;
                if ($absent->is_using_pt == 1) {
                    $membersip = Membership::where('user_id', $absent->member_id)
                        ->where('is_active', 1)
                        ->first(); // Removed select() to get the full object

                    // Pastikan data ditemukan
                    if ($membersip) {
                        // Cek apakah 'user_terkait' kosong atau null
                        if (empty($membersip->user_terkait)) {
                            // Jika kosong, isi dengan ID user terkait (misalnya $absent->member_id)
                            $user_terkait = [$absent->member_id];

                            // Update kolom user_terkait di tabel membership
                            $updated = $membersip->update([
                                'user_terkait' => implode(',', $user_terkait)
                            ]);

                            // Cek apakah update berhasil
                            if (!$updated) {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Gagal mengupdate user_terkait di membership.'
                                ]);
                            }
                        } else {
                            // Jika tidak kosong, proses seperti biasa
                            $user_terkait = array_map('intval', explode(',', $membersip->user_terkait));
                        }

                        $user = User::whereIn('id', $user_terkait)->select('name')->get();
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'Data membership tidak ditemukan.'
                        ]);
                    }
                }

                // Do something with the validated data, e.g., save to the database
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil Proses',
                    'qr' => $request->qr_code,
                    'absen' => $absent,
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
