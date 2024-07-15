<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('member.profile.dashboard');
    }

    public function profile()
    {
        $user = auth()->user();
        $user = DB::table('users')->where('id', $user->id)->get();
        return view('member.profile.profile', compact('user'));
    }

    public function edit_profile() 
    {
        $user = auth()->user();
        $user = DB::table('users')->where('id', $user->id)->get();
        return view('member.profile.edit-profile', compact('user'));
    }

    public function edit_profile_process(Request $request)
    {
        $user = auth()->user();
        $user = DB::table('users')->where('id', $user->id)->get();
        $validate = $request->validate([
            'user_name' => ['required'],
            'user_phone_number' => ['required', 'numeric', 'min:10', 'unique:users,phone_number,' . $user[0]->id],            
        ]);

        if(!$validate) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        $update = DB::table('users')->where('id', $user[0]->id)->update([
            'name' => $request->user_name,
            'address'=> $request->user_address,
            'phone_number' => $request->user_phone_number,
            'email' => $request->user_email,
            'date_of_birth' => $request->user_date_of_birthm,
            'password' => bcrypt($request->user_password),
        ]);

        if($update) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate']);
        }
    }
}
