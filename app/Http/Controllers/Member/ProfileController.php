<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use App\Models\AbsentMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        // $qr_code = DB::table('absent_members')->where('member_id', $user->id)->pluck('path_qr_code')->first();
        $membership = DB::table('memberships')
            ->leftjoin('users', 'memberships.user_id', '=', 'users.id')
            ->where('memberships.user_id', $user->id)
            //->where(function ($query) use ($user) {
            //    $query->where('memberships.user_id', $user->id)
            //        ->orWhere('memberships.user_terkait', 'like', '%' . $user->id . '%');
            // })
            ->where('memberships.is_active', 1)
            ->select('memberships.*', 'users.*', 'memberships.id as id')
            ->orderBy('memberships.created_at', 'desc')
            ->first();

        // dd($membership);
        if ($membership) {
            $startDate = Carbon::parse($membership->start_date);
            $endDate = Carbon::parse($membership->end_date);
            // $membership->duration_in_days = (int) $startDate->diffInDays($endDate);
            $membership->duration_in_days = $membership->duration_in_days;
        }


        return view('member.profile.dashboard', ['membership' => $membership]);
    }

    public function generate_qr_code($is_using_pt)
    {
        $user = auth()->user();
        $data = DB::table('memberships')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where(function ($query) use ($user) {
                $query->where('memberships.user_id', $user->id)
                    ->orWhere('memberships.user_terkait', 'like', '%' . $user->id . '%');
            })
            ->where('memberships.is_active', 1)
            ->select('memberships.*', 'gym_membership_packages.*', 'memberships.id as id', 'gym_membership_packages.id as gym_membership_packages_id', 'gym_membership_packages.type_packages_id as type_packages_id', 'memberships.created_at as membership_created_at')
            ->orderBy('membership_created_at', 'desc')
            ->get();

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 10;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $generate_image_from_qr_code = QrCode::format('png')->size(400)->generate($randomString);
        $string_qr_code = $randomString;
        $qr_code = $string_qr_code . '.png';
        file_put_contents(public_path('build/images/member/qr_code/' . $qr_code), $generate_image_from_qr_code);
        $path_qr_code = 'build/images/member/qr_code/' . $qr_code;

        $absent_member = new AbsentMember();
        $absent_member->qr_code = $randomString;
        $absent_member->path_qr_code = $path_qr_code;
        $absent_member->member_id = $user->id;
        $absent_member->is_using_pt = $is_using_pt;
        $absent_member->type_packages_id  = $data[0]->type_packages_id;
        // $absent_member->id_paket_member = $data[0]->gym_membership_packages_id;
        $absent_member->save();

        // $path_qr_code = 'build/images/member/qr_code/' . $qr_code;
        return $string_qr_code;
    }

    public function qr_code(Request $request)
    {
        $user = auth()->user();
        // get dari table memberships join ke table absent member berdasarkan user_id yg login , end_time = null dan is_using_pt
        $membership_exist = DB::table('memberships')
            ->where('user_id', $user->id)
            ->first();

        $qr_data = AbsentMember::where('member_id', $user->id)
                ->where('end_time', null)
                ->where('is_using_pt', $request->is_using_pt)
                ->get();

        if ($membership_exist != null) {
            if ($request->is_using_pt == 0){
                if (!$qr_data->isEmpty()) {
                    return response()->json(['status' => 'success', 'qr_code' => $qr_data[0]->qr_code]);
                } else {
                    $qr_code = $this->generate_qr_code($request->is_using_pt);
                    return response()->json(['status' => 'success', 'qr_code' => $qr_code]);

                }
            } if ($request->is_using_pt == 1) {
                if (!$qr_data->isEmpty()) {
                    return response()->json(['status' => 'success', 'qr_code' => $qr_data[0]->qr_code]);
                } else {
                    $qr_code = $this->generate_qr_code($request->is_using_pt);
                    return response()->json(['status' => 'success', 'qr_code' => $qr_code]);
                }
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

        if (!$validate) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        if ($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $file_name = time() . "_" . $file->getClientOriginalName();
            $file->move('build/images/member/photo_profile', $file_name);
        }

        $update_data_user = DB::table('users')->where('id', $user[0]->id)->update([
            'photo_profile' => $file_name ?? null,
            'name' => $request->user_name,
            'address' => $request->user_address,
            'phone_number' => $request->user_phone_number,
            'email' => $request->user_email,
            'date_of_birth' => $request->user_date_of_birth,
            'gender' => $request->user_gender,
            // 'password' => bcrypt($request->user_password),
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
