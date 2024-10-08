<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AbsentMember;
use App\Models\JenisLatihan;
use Carbon\Carbon;


class AttendanceMemberController extends Controller
{

    function index(Request $request)
    {
        $data_user = new ProfilePersonalTraining();
        $data_user->index();
        $today = Carbon::today()->toDateString();
        $dataLatihan = JenisLatihan::all();
        $data_member = AbsentMember::
            join('users', 'absent_members.member_id', '=', 'users.id')
            // ->where('personal_trainer_id', auth()->user()->id)
            ->whereDate('absent_members.date', $today)
            ->select('users.name',  'users.phone_number', 'absent_members.*')
            ->get(); 

        return view('personal_training.attendance_member', compact('data_member','dataLatihan', 'data_user'));
        
    }

    public function update(Request $request, $id)
    {
        $latihan = AbsentMember::find($id);
        $latihan->jenis_latihan = implode(", ", $request->jenis_latihan);
        $latihan->save();
        return redirect()->back()->with('success', 'Jenis Latihan berhasil diperbarui');
    }

    public function search(Request $request)
    {
        $searchName = $request->input('searchName');
        $searchDate = $request->input('searchDate');
        $query = AbsentMember::join('users', 'absent_members.member_id', '=', 'users.id');
            // ->where('personal_trainer_id', auth()->user()->id);

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
        return view('personal_training.attendance_member', compact('data_member', 'dataLatihan'));
    }

}
