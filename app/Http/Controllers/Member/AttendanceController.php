<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function history_attendance()
    {
        $user = auth()->user();
        $membership = DB::table('memberships')->where('user_id', $user->id)->first();
        $attendance = DB::table('member_attendances')->where('membership_id', $membership->id)->get();
        return view('member.attendance.history-attendance', compact('attendance'));
    }
}
