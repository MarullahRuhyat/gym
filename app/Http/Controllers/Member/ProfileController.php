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
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            //->where(function ($query) use ($user) {
            //    $query->where('memberships.user_id', $user->id)
            //        ->orWhere('memberships.user_terkait', 'like', '%' . $user->id . '%');
            // })
            ->where('memberships.is_active', 1)
            ->select('memberships.*', 'users.*', 'memberships.id as id', 'gym_membership_packages.name as membership_name')
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
            ->where('memberships.user_id', $user->id)
            ->where('memberships.is_active', 1)
            ->select('gym_membership_packages.type_packages_id as type_packages_id')
            ->get();

        // Generate random string with current date, month, and seconds
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 10;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Append date, seconds, and month to the random string
        $dateTimeString = date('dmHis'); // Day, Month, Hour, Minute, Second
        $randomString .= $dateTimeString;

        $generate_image_from_qr_code = QrCode::format('png')->size(400)->generate($randomString);
        $string_qr_code = $randomString;
        $qr_code = $string_qr_code . '.png';
        $qr_code_path = public_path('build/images/member/qr_code/' . $qr_code);

        // Simpan QR code ke dalam file
        if (file_put_contents($qr_code_path, $generate_image_from_qr_code)) {
            // Cek apakah file QR code berhasil dibuat
            if (file_exists($qr_code_path)) {
                try {
                    $absent_member = new AbsentMember();
                    $absent_member->qr_code = $randomString;
                    $absent_member->path_qr_code = 'build/images/member/qr_code/' . $qr_code;
                    $absent_member->member_id = $user->id;
                    $absent_member->is_using_pt = $is_using_pt;
                    $absent_member->type_packages_id = $data[0]->type_packages_id;
                    $absent_member->save();

                    return response()->json(['status' => 'success', 'qr_code' => $string_qr_code]);
                } catch (\Exception $e) {
                    // Hapus file QR code jika terjadi error saat menyimpan ke database
                    unlink($qr_code_path);
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to create QR code file.']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to save QR code file.']);
        }
    }


    public function testQrcodeHenny($is_using_pt)
    {
        $user = auth()->user();
        $data = DB::table('memberships')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            ->where('memberships.is_active', 1)
            ->select('gym_membership_packages.type_packages_id as type_packages_id')
            ->get();

        if ($data->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No active membership found.']);
        }

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $length = 10;
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Generate QR code
        $generate_image_from_qr_code = QrCode::format('png')->size(400)->generate($randomString);
        $string_qr_code = $randomString;
        $qr_code = $string_qr_code . '.png';
        $path = public_path('build/images/member/qr_code/' . $qr_code);

        DB::beginTransaction();

        try {
            // Save QR code information to database
            $absent_member = new AbsentMember();
            $absent_member->qr_code = $randomString;
            $absent_member->path_qr_code = 'build/images/member/qr_code/' . $qr_code;
            $absent_member->member_id = $user->id;
            $absent_member->is_using_pt = $is_using_pt;
            $absent_member->type_packages_id = $data[0]->type_packages_id;
            $absent_member->save();

            $save_qr_code_image = file_put_contents($path, $generate_image_from_qr_code);
            // $save_qr_code_image = false;

            // Attempt to save the QR code image to the file system
            if (!$save_qr_code_image) {
                // Rollback database changes if file saving fails
                DB::rollBack();
                // Delete the database record as part of cleanup
                $absent_member->delete();
                return response()->json(['status' => false, 'message' => 'Failed to save QR code image.', 'qr_code' => null]);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Berhasil mendapatkan QR', 'qr_code' => $string_qr_code]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage(), 'qr_code' => null]);
        }
    }


    public function generate_qr_code_backup($is_using_pt)
    {
        $user = auth()->user();
        $data = DB::table('memberships')
            ->leftjoin('gym_membership_packages', 'memberships.gym_membership_packages', '=', 'gym_membership_packages.id')
            ->where('memberships.user_id', $user->id)
            // ->where(function ($query) use ($user) {
            //     $query->where('memberships.user_id', $user->id)
            //         ->orWhere('memberships.user_terkait', 'like', '%' . $user->id . '%');
            // })
            ->where('memberships.is_active', 1)
            // ->select('memberships.*', 'gym_membership_packages.*', 'memberships.id as id', 'gym_membership_packages.id as gym_membership_packages_id', 'gym_membership_packages.type_packages_id as type_packages_id', 'memberships.created_at as membership_created_at')
            ->select('gym_membership_packages.type_packages_id as type_packages_id')
            // ->orderBy('membership_created_at', 'desc')
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

        // using try catch to check file saved or not in public path
        try {
            $absent_member = new AbsentMember();
            $absent_member->qr_code = $randomString;
            $absent_member->path_qr_code = $path_qr_code;
            $absent_member->member_id = $user->id;
            $absent_member->is_using_pt = $is_using_pt;
            $absent_member->type_packages_id = $data[0]->type_packages_id;
            // $absent_member->id_paket_member = $data[0]->gym_membership_packages_id;
            $absent_member->save();
            // return $string_qr_code;
            return response()->json(['status' => 'success', 'qr_code' => $string_qr_code]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

        // $path_qr_code = 'build/images/member/qr_code/' . $qr_code;

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
            if ($request->is_using_pt == 0) {
                if (!$qr_data->isEmpty()) {
                    return response()->json(['status' => 'success', 'qr_code' => $qr_data[0]->qr_code]);
                } else {
                    $qr_code = $this->generate_qr_code($request->is_using_pt);
                    return response()->json(['status' => 'success', 'message' => $qr_code->original['message'], 'qr_code' => $qr_code->original['qr_code']]);

                }
            }
            if ($request->is_using_pt == 1) {
                if (!$qr_data->isEmpty()) {
                    return response()->json(['status' => 'success', 'qr_code' => $qr_data[0]->qr_code]);
                } else {
                    $qr_code = $this->generate_qr_code($request->is_using_pt);
                    return response()->json(['status' => 'success', 'message' => $qr_code->original['message'], 'qr_code' => $qr_code->original['qr_code']]);
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

        // join users with informasi_fisik and informasi_fisik_tambahan
        $profile = DB::table('users')
            ->leftjoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->leftjoin('informasi_fisik_tambahan', 'users.id', '=', 'informasi_fisik_tambahan.user_id')
            ->where('users.id', $auth->id)
            ->select('users.*', 'informasi_fisik.*', 'informasi_fisik_tambahan.*', 'users.id as id')
            ->get();

        // insert photo_profile to profile array
        $profile[0]->photo_profile = $photo_profile;
        // dd($profile_tambahan);

        // dd($membership);

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
        // dd($request->all());
        $user = auth()->user();
        $user = DB::table('users')->where('id', $user->id)->get();
        $validate = $request->validate([
            'user_name' => ['required'],
            // 'user_phone_number' => ['required', 'min:10', 'unique:users,phone_number,' . $request->user_id],
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
                // 'password' => bcrypt($request->user_password),
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        // $update_informasi_fisik = DB::table('informasi_fisik')->where('user_id', $request->user_id)->update([
        //     'tinggi_badan' => $request->tinggi_badan,
        //     'berat_badan' => $request->berat_badan,
        //     // 'massa_otot' => $request->massa_otot ?? null,
        //     // 'massa_tulang' => $request->massa_tulang ?? null,
        //     // 'persentase_lemak_tubuh' => $request->persentase_lemak_tubuh ?? null,
        //     // 'intoleransi_latihan_atau_alergi' => $request->intoleransi_latihan_atau_alergi ?? null,
        // ]);

        // $update_informasi_fisik_tambahan = DB::table('informasi_fisik_tambahan')->where('user_id', $request->user_id)->update([
        //     'leher' => $request->leher,
        //     'bahu' => $request->bahu,
        //     'dada' => $request->dada,
        //     'lengan_kanan' => $request->lengan_kanan,
        //     'lengan_kiri' => $request->lengan_kiri,
        //     'fore_arm_kanan' => $request->fore_arm_kanan,
        //     'fore_arm_kiri' => $request->fore_arm_kiri,
        //     'perut' => $request->perut,
        //     'pinggang' => $request->pinggang,
        //     'paha_kanan' => $request->paha_kanan,
        //     'paha_kiri' => $request->paha_kiri,
        //     'betis_kanan' => $request->betis_kanan,
        //     'betis_kiri' => $request->betis_kiri,
        // ]);

        if (DB::table('informasi_fisik')->where('user_id', $user[0]->id)->exists()) {
            $update_data_informasi_fisik = DB::table('informasi_fisik')->where('user_id', $user[0]->id)->update([
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
            ]);
        } else {
            $update_data_informasi_fisik = DB::table('informasi_fisik')->insert([
                'user_id' => $request->user_id,
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
                'user_id' => $request->user_id,
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

    public function check_qr_status() {
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
