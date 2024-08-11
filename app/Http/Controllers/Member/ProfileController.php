<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfileController extends Controller
{
    private function photo_profile()
    {
        $auth = auth()->user();
        $gender = DB::table('users')->where('id', $auth->id)->pluck('gender')->first();
        $photo_profile = DB::table('users')->where('id', $auth->id)->pluck('photo_profile')->first();
        $photo_profile = null;
        if ($gender == 'P') {
            $photo_profile = 'default-user-women.jpg';
        } else {
            $photo_profile = 'default-user-male.jpg';
        }
        return $photo_profile;
    }


    public function dashboard()
    {
        $user = auth()->user();
        $qr_code = DB::table('qr_code')->where('user_id', $user->id)->pluck('path_qr_code')->first();
        $membership = DB::table('memberships')
        // ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
        ->leftjoin('users', 'memberships.user_id', '=', 'users.id')
        ->where(function($query) use ($user) {
            $query->where('memberships.user_id', $user->id)
                ->orWhere('memberships.user_terkait', 'like', '%' . $user->id . '%');
        })
        // ->select('memberships.*', 'gym_membership_packages.*', 'memberships.id as id', 'gym_membership_packages.id as gym_membership_packages_id')
        ->select('memberships.*', 'users.*', 'memberships.id as id')
        // get only latest membership desc
        ->orderBy('memberships.created_at', 'desc') // Mengurutkan berdasarkan tanggal pembuatan secara menurun
        ->first();

        // dd($membership);


        return view('member.profile.dashboard', ['membership' => $membership]);
    }

    public function qr_code(Request $request) {
        $user = auth()->user();
        $membership = DB::table('memberships')
        ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
        ->where(function ($query) use ($user) {
            $query->where('memberships.user_id', $user->id)
                ->orWhere('memberships.user_terkait', 'like', '%' . $user->id . '%');
        })
        ->where('memberships.is_active', 1)
        ->select('memberships.*', 'gym_membership_packages.*', 'memberships.id as id', 'gym_membership_packages.id as gym_membership_packages_id')
        ->get();

        $user_exist = DB::table('qr_code')
            ->where('user_id', $user->id)
            ->where('is_using_pt', $request->is_using_pt)
            ->first();

        if (!$membership->isEmpty()) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $length = 10;
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            if(!$user_exist) {
                // foreach ($membership as $key => $value) {
                    // $membership_user_id = $value->user_id;
                    // $expired_at = date('Y-m-d', strtotime($value->start_date . '+' . $value->duration_in_days . ' days'));
                $membership_user_id = $user->id;
                $expired_at = date('Y-m-d', strtotime($membership[0]->start_date . '+' . $membership[0]->duration_in_days . ' days'));
                $pt = $request->is_using_pt == 1 ? 'PT' : 'non-PT';
                $qr_code = $randomString . '-' . $pt . '.png';
                $path_qr_code = 'build/images/member/qr_code/' . $qr_code;

                $qr_details = json_encode([
                    'member_id' => $membership_user_id,
                    'qr_code' => $qr_code,
                    'path_qr_code' => $path_qr_code,
                    'tipe' => 'harian', // ganti ketika udah ada tipe membership di package
                    'is_using_pt' => $request->is_using_pt,
                ]);
                // }
                $insert_data_qr_code= DB::table('qr_code')->insert([
                    'user_id' => $user->id,
                    'qr_code' => $qr_code,
                    'path_qr_code' => $path_qr_code,
                    'status' => 'active',
                    'expired_at' => $expired_at,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'is_using_pt' => $request->is_using_pt,
                ]);
                // $qr_code = DB::table('qr_code')->where('user_id', $user->id)->pluck('path_qr_code')->first();
                // $generate_image_from_qr_code = QrCode::format('png')->size(200)->generate($qr_details);
                // $generate_image_from_qr_code = QrCode::generate(
                //     'Hello, World!',
                // );
                // format png can be scanned by camera
                $generate_image_from_qr_code = QrCode::format('png')->size(400)->generate($qr_details);

                file_put_contents(public_path('build/images/member/qr_code/' . $qr_code), $generate_image_from_qr_code);

                return response()->json(['status' => 'success', 'qr_code' => $qr_code]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'QR Code sudah ada', 'qr_code' => $user_exist->qr_code]);
            }

        } else {
            return response()->json(['status' => 'error', 'message' => 'Anda belum memiliki membership']);
        }
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
            'gender' => $request->user_gender,
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
