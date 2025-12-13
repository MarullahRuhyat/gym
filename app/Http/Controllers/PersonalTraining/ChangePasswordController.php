<?php

namespace App\Http\Controllers\PersonalTraining;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class ChangePasswordController extends Controller
{
    public function index()
    {
        // Get all users from all types (admin, member, personal trainer) without any limit
        // Count total users first for debugging
        $totalUsers = DB::table('users')->count();
        
        // Get all users without any limit or scope
        $users = User::query()
            ->orderBy('name', 'asc')
            ->get();
            
        return view('personal_training.change_password', compact('users', 'totalUsers'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|min:6',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('personal_trainer.change_password_user')->with('success', 'Password berhasil diubah!');
        } catch (Exception $e) {
            return redirect()->route('personal_trainer.change_password_user')->with('error', 'Gagal mengubah password: ' . $e->getMessage());
        }
    }
}
