<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
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
                'phone_number' => 'nullable|string|max:20',
            ]);
            $data = $request->only('name', 'phone_number');

            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    $user = User::findOrFail($id);
                    $user->update($data);
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
}
