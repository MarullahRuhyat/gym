<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Str;
use App\Models\AbsentMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InputManualAttendanceController extends Controller
{
    public function index()
    {
        $user = User::all();
        $pt = User::where('role', 'personal trainer')->get();
        return view('admin.input_manual_attendance', compact('user', 'pt'));
    }

    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'user_id' => 'required',
            'pt_id' => 'required',
            'date' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);
        $type_packages_id = Membership::where('user_id', $request->user_id)->latest()->first()->type_packages_id;
        // store data
        AbsentMember::create([
            'member_id' => $request->user_id,
            'personal_trainer_id' => $request->pt_id,
            'date' => $request->date,
            'start_time' => $request->time_in,
            'end_time' => $request->time_out,
            'type_packages_id' => $type_packages_id,
            // random qr code
            'qr_code' => Str::random(10),
            'path_qr_code' => Str::random(10),
        ]);

        // update available_personal_trainer_quota -1
        User::where('id', $request->user_id)->update([
            'available_personal_trainer_quota' => DB::raw('available_personal_trainer_quota - 1'),
        ]);
        return redirect()->route('admin_input_manual_attendance')->with('success', 'Data berhasil disimpan!');
    }
}
