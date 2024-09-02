<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\AbsentMember;
use App\Models\JenisLatihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $dataLatihan = JenisLatihan::all();
        // $data_member = AbsentMember::join('users', 'absent_members.member_id', '=', 'users.id')
        //     ->whereDate('absent_members.date', $today)
        //     ->select('users.name',  'users.phone_number', 'absent_members.*')
        //     ->get();

        $data_member = AbsentMember::join('users as member', 'absent_members.member_id', '=', 'member.id')
            ->leftJoin('users as trainer', 'absent_members.personal_trainer_id', '=', 'trainer.id')
            ->whereDate('absent_members.date', $today)
            ->select(
                'member.name as member_name',
                'member.phone_number',
                'absent_members.*',
                'trainer.name as trainer_name'
            )
            ->get();

        return view('admin.absen', compact('data_member', 'dataLatihan'));
    }
    public function search(Request $request)
    {
        $searchName = $request->input('searchName');
        $searchDate = $request->input('searchDate');

        $query = AbsentMember::join('users as member', 'absent_members.member_id', '=', 'member.id')
            ->leftJoin('users as trainer', 'absent_members.personal_trainer_id', '=', 'trainer.id');

        if ($searchName) {
            $query->where('member.name', 'like', '%' . $searchName . '%');
        }

        if ($searchDate) {
            $query->whereDate('absent_members.date', $searchDate);
        } else {
            $today = Carbon::today()->toDateString();
            $query->whereDate('absent_members.date', $today);
        }

        $data_member = $query->select(
            'member.name as member_name',
            'member.phone_number',
            'absent_members.*',
            'trainer.name as trainer_name'
        )
            ->get();

        if ($request->ajax()) {
            return response()->json($data_member);
        }

        $dataLatihan = JenisLatihan::all();
        return view('admin.absen', compact('data_member', 'dataLatihan'));
    }

}
