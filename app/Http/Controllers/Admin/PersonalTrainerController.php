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
                    'phone_number' => 'nullable|string|max:20',
                    'status' => 'required|string',
                ]);
            }

            $data = $request->only('name', 'password', 'phone_number', 'status');


            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    $user = User::findOrFail($id);
                    if ($user->phone_number != $request->phone_number) {
                        $cek_phone = User::where('phone_number', $request->phone_number)->first();
                        if ($cek_phone) {
                            return redirect()->route('admin_personal_trainer')->with('error', 'No hp telah digunakan!');
                        }
                    }
                    $user->update([
                        'name' => $request->name,
                        'phone_number' => $request->phone_number,
                        'status' => $request->status,
                    ]);

                    return redirect()->route('admin_personal_trainer')->with('success', 'Data berhasil diperbarui!');
                } elseif ($delete == 1 && $id) {
                    $user = User::findOrFail($id);
                    $user->delete();
                    return redirect()->route('admin_personal_trainer')->with('success', 'Data berhasil dihapus!');
                } else {
                    $cek_phone = User::where('phone_number', $request->phone_number)->first();
                    if ($cek_phone) {
                        return redirect()->route('admin_personal_trainer')->with('error', 'No hp telah digunakan!');
                    }
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
