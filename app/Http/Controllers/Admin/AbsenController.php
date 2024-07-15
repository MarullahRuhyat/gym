<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\AbsentMember;
use App\Models\JenisLatihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenController extends Controller
{
    function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $dataLatihan = JenisLatihan::all();
        $data_member = AbsentMember::
            join('users', 'absent_members.member_id', '=', 'users.id')
            // ->where('personal_trainer_id', auth()->user()->id)
            ->whereDate('absent_members.date', $today)
            ->select('users.name',  'users.phone_number', 'absent_members.*')
            ->get(); 
        return view('admin.absen',compact('data_member','dataLatihan'));
    }
    public function search(Request $request)
    {
        $searchName = $request->input('searchName');
        $searchDate = $request->input('searchDate');
        $query = AbsentMember::join('users', 'absent_members.member_id', '=', 'users.id');

        if ($searchName) {
            $query->where('users.name', 'like', '%' . $searchName . '%');
        }

        if ($searchDate) {
            $query->whereDate('date', $searchDate);
        } else {
            $today = Carbon::today()->toDateString();
            $query->whereDate('date', $today);
        }

        $data_member = $query->select('users.name', 'users.phone_number', 'absent_members.*')->get();

        if ($request->ajax()) {
            return response()->json($data_member);
        }
        

        $dataLatihan = JenisLatihan::all();
        return view('admin.absen', compact('data_member', 'dataLatihan'));
    }
}
