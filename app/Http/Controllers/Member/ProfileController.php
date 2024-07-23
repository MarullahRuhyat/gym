<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfileController extends Controller
{
    private function photo_profile()
    {
        $auth = auth()->user();
        $gender = DB::table('users')->where('id', $auth->id)->pluck('gender')->first();
        $photo_profile = DB::table('users')->where('id', $auth->id)->pluck('photo_profile')->first();
        $photo_profile = null;
        if ($gender == 'L') {
            $photo_profile = 'default-user-male.jpg';
        } else if ($gender == 'P') {
            $photo_profile = 'default-user-women.jpg';
        } else {
            $photo_profile = 'default.jpg';
        }
        return $photo_profile;
    }


    public function dashboard()
    {
        $user = auth()->user();
        $membership = DB::table('memberships')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            ->select('memberships.*', 'gym_membership_packages.*', 'memberships.id as id', 'gym_membership_packages.id as gym_membership_packages_id')
            ->get();

        $qr_code = DB::table('qr_code')->where('user_id', $user->id)->first();

        if ($qr_code) {
            $qr_code->path_qr_code = '/build/images/member/qr_code/'. $qr_code->path_qr_code;
        } if ($membership->isEmpty()) {
            return view('member.profile.dashboard', compact('membership'));
        }
        else {
            $image_name = 'qr_code_' . $user->id . '_' . $membership[0]->id . '.png';
            $insert_data_qr_code= DB::table('qr_code')->insert([
                'user_id' => $user->id,
                'qr_code' => $image_name,
                'path_qr_code' => '/build/images/member/qr_code/' . $image_name,
                'status' => 'active',
                'expired_at' => date('Y-m-d', strtotime($membership[0]->start_date . '+' . $membership[0]->duration_in_days . ' days')),
            ]);
            // move image to storage
            // $save_image = file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $insert_data_qr_code);
            // file_put_contents(public_path('build/images/member/qr_code/' . $image_name), $save_image);


            // generate qr code and save to public path
            // $qr_code = QrCode::size(200)->generate('https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . $insert_data_qr_code);
            // $qr_code->save(public_path('build/images/member/qr_code/' . $image_name));

        
            $save_qr_code = (object) ['path_qr_code' => $image_name];   
            dd($save_qr_code);     
        }

        // return view('member.profile.dashboard', compact('membership'));
    }

    public function profile()
    {
        $auth = auth()->user();
        $photo_profile = $this->photo_profile();      

        $profile = DB::table('users')
            ->leftJoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->where('users.id', $auth->id)
            ->select('users.*', 'informasi_fisik.*', 'users.id as id')
            ->get();

        // insert photo_profile to profile array
        $profile[0]->photo_profile = $photo_profile;
            
        return view('member.profile.profile', compact('profile'));
    }

    public function edit_profile()
    {
        $auth = auth()->user();
        $photo_profile = $this->photo_profile();
        $profile = DB::table('users')
            ->leftjoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->where('users.id', $auth->id)
            ->select('users.*', 'informasi_fisik.*', 'users.id as id')
            ->get();
        $profile[0]->photo_profile = $photo_profile;
            
        return view('member.profile.edit-profile', compact('profile'));
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
