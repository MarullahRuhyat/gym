<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        // join table memberships and gym_membership_packages
        $membership = DB::table('memberships')
            ->join('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            ->get();
        return view('member.profile.dashboard', compact('membership'));
    }

    public function profile()
    {
        $auth = auth()->user();
        $user = DB::table('users')->where('id', $auth->id)->get();
        $informasi_fisik = DB::table('informasi_fisik')->where('user_id', $auth->id)->get();
        return view('member.profile.profile', compact('user', 'informasi_fisik'));
    }

    public function edit_profile()
    {
        $auth = auth()->user();
        $user = DB::table('users')->where('id', $auth->id)->get();
        $informasi_fisik = DB::table('informasi_fisik')->where('user_id', $auth->id)->get();
        return view('member.profile.edit-profile', compact('user', 'informasi_fisik'));
    }

    public function edit_profile_process(Request $request)
    {
        $user = auth()->user();
        $user = DB::table('users')->where('id', $user->id)->get();
        $validate = $request->validate([
            'user_name' => ['required'],
            'user_phone_number' => ['required', 'min:10', 'unique:users,phone_number,' . $user[0]->id],
        ]);

        if(!$validate) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        if($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $file_name = time() . "_" . $file->getClientOriginalName();
            $file->move('build/images/member/photo_profile', $file_name);
        }

        $update_data_user = DB::table('users')->where('id', $user[0]->id)->update([
            'photo_profile' => $file_name ?? null,
            'name' => $request->user_name,
            'address'=> $request->user_address,
            'phone_number' => $request->user_phone_number,
            'email' => $request->user_email,
            'date_of_birth' => $request->user_date_of_birth,
            'password' => bcrypt($request->user_password),
        ]);

        $update_informasi_fisik = DB::table('informasi_fisik')->where('user_id', $user[0]->id)->update([
            'tinggi_badan' => $request->tinggi_badan ?? null,
            'berat_badan' => $request->berat_badan ?? null,
            'massa_otot' => $request->massa_otot ?? null,
            'massa_tulang' => $request->massa_tulang ?? null,
            'persentase_lemak_tubuh' => $request->persentase_lemak_tubuh ?? null,
            'intoleransi_latihan_atau_alergi' => $request->intoleransi_latihan_atau_alergi ?? null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate']);
    }
}
