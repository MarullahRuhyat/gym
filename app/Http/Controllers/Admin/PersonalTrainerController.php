<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PersonalTrainerController extends Controller
{
    //
    function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // Handle POST request
            $edit = intval($request->input('edit', 0));
            $delete = intval($request->input('delete', 0));
            if ($delete == 0) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'password' => 'required|string',
                    'phone_number' => 'nullable|string|max:20',
                ]);
            }
            $data = $request->only('name', 'password', 'phone_number');

            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    $user = User::findOrFail($id);
                    $user->update($data);
                    return redirect()->route('admin_personal_trainer')->with('success', 'Data berhasil diperbarui!');
                } elseif ($delete == 1 && $id) {
                    $user = User::findOrFail($id);
                    $user->delete();
                    return redirect()->route('admin_personal_trainer')->with('success', 'Data berhasil dihapus!');
                } else {
                    $data['password'] = bcrypt($data['password']); // Securely hash the password
                    $data['role'] = 'personal trainer';
                    User::create($data);
                    return redirect()->route('admin_personal_trainer')->with('success', 'Data berhasil disimpan!');
                }
            } catch (Exception $e) {
                return redirect()->route('admin_personal_trainer')->with('error', 'Data gagal disimpan!');
            }
        }

        $users = User::where('role', 'personal trainer')->get();
        return view('admin.personal_trainer', compact('users'));
    }
}
