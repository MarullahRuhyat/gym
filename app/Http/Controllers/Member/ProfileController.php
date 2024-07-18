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
            'user_phone_number' => ['required', 'min:10', 'unique:users,phone_number,' . $user[0]->id],            
        ]);

        if(!$validate) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        // $update = DB::table('users')->where('id', $user[0]->id)->update([
        //     'name' => $request->user_name,
        //     'address'=> $request->user_address,
        //     'phone_number' => $request->user_phone_number,
        //     'email' => $request->user_email,
        //     'date_of_birth' => $request->user_date_of_birthm,
        //     'password' => bcrypt($request->user_password),
        // ]);

        // if has photo_profile save photo then store to public/build/images/member/photo_profile 
        if($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $file_name = time() . "_" . $file->getClientOriginalName();
            $file->move('build/images/member/photo_profile', $file_name);
            $update = DB::table('users')->where('id', $user[0]->id)->update([
                'name' => $request->user_name,
                'address'=> $request->user_address,
                'phone_number' => $request->user_phone_number,
                'email' => $request->user_email,
                'date_of_birth' => $request->user_date_of_birth,
                'password' => bcrypt($request->user_password),
                'photo_profile' => $file_name,
            ]);
        } else {
            $update = DB::table('users')->where('id', $user[0]->id)->update([
                'name' => $request->user_name,
                'address'=> $request->user_address,
                'phone_number' => $request->user_phone_number,
                'email' => $request->user_email,
                'date_of_birth' => $request->user_date_of_birth,
                'password' => bcrypt($request->user_password),
            ]);
        }

        if($update) {
            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data gagal diupdate']);
        }
    }
}
