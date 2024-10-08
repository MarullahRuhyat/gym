<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\AbsentMember;
use App\Models\JenisLatihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $dataLatihan = JenisLatihan::all();

        $data_member = AbsentMember::join('users as member', 'absent_members.member_id', '=', 'member.id')
            ->leftJoin('users as trainer', 'absent_members.personal_trainer_id', '=', 'trainer.id')
            ->whereDate('absent_members.date', $today)
            ->select(
                'member.name as member_name',
                'member.phone_number',
                'absent_members.*',
                'trainer.name as trainer_name',
                'absent_members.id as id_absent'
            )
            ->get();
            // dd($data_member);

        $personal_trainers = User::where('role', 'personal trainer')->get();
        return view('admin.absen', compact('data_member', 'dataLatihan', 'personal_trainers'));
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
            'trainer.name as trainer_name',
            'absent_members.id as id_absent'
        )
            ->get();

        if ($request->ajax()) {
            return response()->json($data_member);
        }

        $dataLatihan = JenisLatihan::all();

        dd($data_member);
        return view('admin.absen', compact('data_member', 'dataLatihan'));
    }

    function ajax_detail_members(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:255',
        ]);
        try {
            $id = $request->id;
            $absent = AbsentMember::with('member')->find($id);
            if ($absent) {

                $user = null;
                if ($absent->is_using_pt == 1) {
                    $membersip = Membership::where('user_id', $absent->member_id)->where('is_active', 1)->select('user_terkait')->first();
                    $user_terkait = array_map('intval', explode(',', $membersip->user_terkait));
                    $user = User::whereIn('id',  $user_terkait)->select('name')->get();
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


    public function add_pt_manual(Request $request) {
        $absentMember = AbsentMember::find($request->id_absent);
        $absentMember->personal_trainer_id = $request->personal_trainer_id;
        $absentMember->save();

        return redirect()->back()->with('success', 'Personal trainer successfully assigned.');
    }


}
