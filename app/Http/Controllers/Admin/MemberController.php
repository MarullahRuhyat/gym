<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MemberController extends Controller
{
    //
    function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // Handle POST request
            $edit = intval($request->input('edit', 0));
            $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'status' => 'required|string|max:20',
                'available_personal_trainer_quota' => 'required|integer',
            ]);
            $data = $request->only('name', 'phone_number', 'status', 'available_personal_trainer_quota');

            try {
                $id = $request->input('id', 0);
                if ($edit == 1 && $id) {
                    $user = User::findOrFail($id);
                    $user->update($data);
                    $membership = Membership::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    if ($membership) {
                        if ($request->status == "active") {
                            $membership->is_active = 1;
                        } else {
                            $membership->is_active = 0;
                        }
                        $membership->save();
                    } else {
                        return redirect()->route('admin_member')->with('error', 'Membership not found for the user!');
                    }
                    return redirect()->route('admin_member')->with('success', 'Data berhasil diperbarui!');
                }
            } catch (Exception $e) {
                return redirect()->route('admin_member')->with('error', 'Data gagal disimpan!');
            }
        }
        $perPage = 10;
        $users = User::where('role', 'member');
        $page = $request->query('page', 1);
        $name = $request->query('name', '');
        if ($name != '') {
            $users->where('name', 'LIKE', '%' . $name . '%');
        }
        $results = $users->paginate($perPage, ['*'], 'page', $page);
        $total_page = intval(ceil($results->total() / $results->perPage()));

        if ($request->ajax()) {
            return view('admin.member.data', compact('results', 'total_page'))->render();
        }
        return view('admin.member.index', compact('results', 'total_page'));
    }

    public function store(Request $request)
    {
        foreach ($request->all() as $data) {
            $user = User::create($data);
        }

        return response()->json(['success' => true]);
    }

    public function detail(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->gender == 'P') {
            $photo_profile = 'default-user-women.jpg';
        } else {
            $photo_profile = 'default-user-male.jpg';
        }

        $profile = DB::table('users')
            ->leftjoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->leftjoin('informasi_fisik_tambahan', 'users.id', '=', 'informasi_fisik_tambahan.user_id')
            ->where('users.id', $user->id)
            ->select('users.*', 'informasi_fisik.*', 'informasi_fisik_tambahan.*', 'users.id as id')
            ->get();

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

        $available_personal_trainer_quota = $user->available_personal_trainer_quota;

        // check di table absent_members data user_id yang sama dengan user_id di table users yang is_using_pt = 1 dan check siapa saja nama pt nya dan kapan kapan saja dia menggunakan pt
        $absent_members = DB::table('absent_members')
            ->leftjoin('users', 'absent_members.member_id', '=', 'users.id')
            ->leftjoin('users as personal_trainers', 'absent_members.personal_trainer_id', '=', 'personal_trainers.id')
            ->where('absent_members.member_id', $user->id)
            ->where('absent_members.is_using_pt', 1)
            ->select('absent_members.*', 'users.name as member_name', 'personal_trainers.name as pt_name')
            ->get();


        // insert photo_profile to profile array
        $profile[0]->photo_profile = $photo_profile;

        return view('admin.member.detail', compact('profile', 'membership', 'absent_members', 'available_personal_trainer_quota'));
    }

    public function delete($id)
    {
        // ambil member_id dari table absent_members
        $member_id = DB::table('absent_members')
            ->where('id', $id)
            ->select('member_id')
            ->first();

        // hapus data dari table absent_members
        $absent_members = DB::table('absent_members')
            ->where('id', $id)
            ->delete();

        // tambah 1 available_personal_trainer_quota di table users
        $user = User::find($member_id->member_id);
        $user->available_personal_trainer_quota += 1;
        $user->save();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function update_available_personal_trainer_quota(Request $request, $id)
    {
        $user = User::find($id);
        $user->available_personal_trainer_quota = $request->available_personal_trainer_quota;
        $user->save();
        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    public function otp_member()
    {

        $otp_member = DB::table('users')
            ->where('otp_expired_at', '>', now())
            ->select('phone_number', 'otp', 'name', 'otp_expired_at')
            ->orderBy('otp_expired_at', 'desc')
            ->get();
        return view(
            'admin.member.otp_member',
            compact('otp_member')
        );
    }
}
