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
        $users = User::where('role', 'member')->get();
        return view('admin.member', compact('users'));
    }
}
