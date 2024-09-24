<?php

namespace App\Http\Controllers\Member;

use Carbon\Carbon;
use Illuminate\Support\Str;
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
        $membership = DB::table('memberships')
            ->leftjoin('users', 'memberships.user_id', '=', 'users.id')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            ->where('memberships.is_active', 1)
            ->select('memberships.*', 'users.*', 'memberships.id as id', 'gym_membership_packages.name as membership_name')
            ->orderBy('memberships.created_at', 'desc')
            ->first();

        if ($membership) {
            $startDate = Carbon::parse($membership->start_date);
            $endDate = Carbon::parse($membership->end_date);
            $membership->duration_in_days = $membership->duration_in_days;
        }

        if ($membership == null) {
            $enddateformprofile = null;
        } else {
            $enddateformprofile = Carbon::parse($membership->end_date);
        }

       


        return view('member.profile.dashboard', ['membership' => $membership, 'enddateformprofile' => $enddateformprofile]);
    }



    public function generate_qr_code($is_using_pt)
    {
        $user = auth()->user();
        $data = DB::table('memberships')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            ->where('memberships.is_active', 1)
            ->select('gym_membership_packages.type_packages_id as type_packages_id')
            ->get();

        $randomString = Str::random(10);
        $dateTimeString = date('dmHis');
        $randomString .= $dateTimeString;
        $generate_image_from_qr_code = QrCode::format('png')->size(400)->generate($randomString);
        $base64_qr_code = base64_encode($generate_image_from_qr_code);

        try {
            $absent_member = new AbsentMember();
            $absent_member->qr_code = $randomString;
            $absent_member->path_qr_code = $base64_qr_code;
            $absent_member->member_id = $user->id;
            $absent_member->is_using_pt = $is_using_pt;
            $absent_member->type_packages_id = $data[0]->type_packages_id;
            $absent_member->save();

            return response()->json(['status' => 'success', 'qr_code' => $base64_qr_code]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function qr_code(Request $request)
    {
        $user = auth()->user();
        $membership_exist = DB::table('memberships')
            ->where('user_id', $user->id)
            ->first();

        $qr_data = AbsentMember::where('member_id', $user->id)
            ->where('end_time', null)
            ->where('is_using_pt', $request->is_using_pt)
            ->first();

        if ($membership_exist != null) {
            if ($qr_data) {
                return response()->json([
                    'status' => 'success',
                    'qr_code' => $qr_data->path_qr_code,
                ]);
            } else {
                $qr_code = $this->generate_qr_code($request->is_using_pt);
                $message = $qr_code->original['message'] ?? 'Default message';
                $qr_code_value = $qr_code->original['qr_code'] ?? null;
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'qr_code' => $qr_code_value
                ]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Anda belum memiliki membership']);
        }
    }

    public function profile()
    {
        $auth = auth()->user();
        $photo_profile = $this->photo_profile();

        $membership = DB::table('memberships')
            ->leftjoin('users', 'memberships.user_id', '=', 'users.id')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $auth->id)
            ->where('memberships.is_active', 1)
            ->select('memberships.*', 'users.*', 'memberships.id as id', 'gym_membership_packages.name as membership_name')
            ->orderBy('memberships.created_at', 'desc')
            ->first();
        if ($membership) {
            $startDate = Carbon::parse($membership->start_date);
            $endDate = Carbon::parse($membership->end_date);
            $membership->duration_in_days = $membership->duration_in_days;
        }


        $profile = DB::table('users')
            ->leftjoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->leftjoin('informasi_fisik_tambahan', 'users.id', '=', 'informasi_fisik_tambahan.user_id')
            ->where('users.id', $auth->id)
            ->select('users.*', 'informasi_fisik.*', 'informasi_fisik_tambahan.*', 'users.id as id')
            ->get();

        $profile[0]->photo_profile = $photo_profile;
        return view('member.profile.profile', compact('profile', 'membership'));
    }

    public function edit_profile()
    {
        $auth = auth()->user();
        $photo_profile = $this->photo_profile();
        $profile = DB::table('users')
            ->leftjoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->leftjoin('informasi_fisik_tambahan', 'users.id', '=', 'informasi_fisik_tambahan.user_id')
            ->where('users.id', $auth->id)
            ->select('users.*', 'informasi_fisik.*', 'users.id as id', 'informasi_fisik_tambahan.*')
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
        ]);

        if (!$validate) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid']);
        }

        if ($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $file_name = time() . "_" . $file->getClientOriginalName();
            $file->move('build/images/member/photo_profile', $file_name);
        }

        $user_exist = DB::table('users')->where('id', $user[0]->id)->exists();
        if ($user_exist) {
            $update_data_user = DB::table('users')->where('id', $user[0]->id)->update([
                'photo_profile' => $file_name ?? null,
                'name' => $request->user_name,
                'address' => $request->user_address,
                'phone_number' => $request->user_phone_number,
                'email' => $request->user_email,
                'date_of_birth' => $request->user_date_of_birth,
                'gender' => $request->user_gender,

            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        if (DB::table('informasi_fisik')->where('user_id', $user[0]->id)->exists()) {
            $update_data_informasi_fisik = DB::table('informasi_fisik')->where('user_id', $user[0]->id)->update([
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
            ]);
        } else {
            $update_data_informasi_fisik = DB::table('informasi_fisik')->insert([
                'user_id' => $user[0]->id,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
            ]);
        }

        if (DB::table('informasi_fisik_tambahan')->where('user_id', $request->user_id)->exists()) {
            $update_data_informasi_fisik_tambahan = DB::table('informasi_fisik_tambahan')->where('user_id', $user[0]->id)->update([
                'leher' => $request->leher,
                'bahu' => $request->bahu,
                'dada' => $request->dada,
                'lengan_kanan' => $request->lengan_kanan,
                'lengan_kiri' => $request->lengan_kiri,
                'fore_arm_kanan' => $request->fore_arm_kanan,
                'fore_arm_kiri' => $request->fore_arm_kiri,
                'perut' => $request->perut,
                'pinggang' => $request->pinggang,
                'paha_kanan' => $request->paha_kanan,
                'paha_kiri' => $request->paha_kiri,
                'betis_kanan' => $request->betis_kanan,
                'betis_kiri' => $request->betis_kiri,
            ]);
        } else {
            $update_data_informasi_fisik_tambahan = DB::table('informasi_fisik_tambahan')->insert([
                'user_id' => $user[0]->id,
                'leher' => $request->leher,
                'bahu' => $request->bahu,
                'dada' => $request->dada,
                'lengan_kanan' => $request->lengan_kanan,
                'lengan_kiri' => $request->lengan_kiri,
                'fore_arm_kanan' => $request->fore_arm_kanan,
                'fore_arm_kiri' => $request->fore_arm_kiri,
                'perut' => $request->perut,
                'pinggang' => $request->pinggang,
                'paha_kanan' => $request->paha_kanan,
                'paha_kiri' => $request->paha_kiri,
                'betis_kanan' => $request->betis_kanan,
                'betis_kiri' => $request->betis_kiri,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate']);
    }

    public function check_qr_status()
    {
        $user = auth()->user();
        $checking_absent_today = DB::table('absent_members')
            ->where('member_id', $user->id)
            ->where('date', Carbon::today())
            ->where('end_time', null)
            ->get();
        if ($checking_absent_today->isEmpty()) {
            return response()->json(['qr_type' => 'datang']);
        } else {
            return response()->json(['qr_type' => 'pulang']);
        }
    }
}
