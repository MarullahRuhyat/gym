<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AbsentMember;
use App\Models\JenisLatihan;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function history_attendance()
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();
        $dataLatihan = JenisLatihan::all();
        $data_member = AbsentMember::
            join('users', 'absent_members.member_id', '=', 'users.id')
            ->where('personal_trainer_id', auth()->user()->id)
            ->whereDate('absent_members.date', $today)
            ->select('users.name',  'users.phone_number', 'absent_members.*')
            ->get(); 

        return view('member.attendance.history_attendance', compact('data_member','dataLatihan'));
    }
}
