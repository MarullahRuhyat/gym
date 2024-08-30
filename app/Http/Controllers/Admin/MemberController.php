<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            ]);
            $data = $request->only('name', 'phone_number', 'status');

            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    $user = User::findOrFail($id);
                    $user->update($data);
                    $membership = Membership::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    if ($request->status == "active") {
                        $membership->is_active = 1;
                    } else {
                        $membership->is_active = 0;
                    }
                    $membership->save();
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
        // response [{}, {}];
        // save all data inside the object request

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
            ->leftJoin('informasi_fisik', 'users.id', '=', 'informasi_fisik.user_id')
            ->where('users.id', $user->id)
            ->select('users.*', 'informasi_fisik.*', 'users.id as id')
            ->get();

        // insert photo_profile to profile array
        $profile[0]->photo_profile = $photo_profile;

        return view('admin.member.detail', compact('profile'));
    }
}
