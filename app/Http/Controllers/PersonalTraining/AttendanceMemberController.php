<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AbsentMember;
use Carbon\Carbon;


class AttendanceMemberController extends Controller
{
    function index(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $today2= AbsentMember::whereDate('date', $today)->get();

        $data_member = AbsentMember::
            join('users', 'absent_members.member_id', '=', 'users.id')
            ->where('personal_trainer_id', auth()->user()->id)
            ->where('users.status', 'active')
            ->whereDate('absent_members.created_at', $today)
            ->select('users.name',  'users.phone_number', 'absent_members.*')
            ->get();  
        return view('personal_training.attendance_member', compact('data_member'));
        
    }
}
