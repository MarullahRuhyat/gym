<?php

namespace App\Http\Controllers\PersonalTraining;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilePersonalTraining extends Controller
{
    public function index() {
        $data_user = auth()->user();
        return view('personal_training.profile', compact('data_user'));
    }

    public function editProfile(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        $data_user = auth()->user();
        $data_user->update($request->all());
        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }

    public function changePassword(Request $request) {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|same:confirm_password',
            'confirm_password' => 'required|string|min:8',
        ]);
    
        // Check if the new password is the same as the old password
        if ($request->old_password === $request->new_password) {
            return redirect()->back()->with('error', 'New password cannot be the same as the old password.');
        }
    
        // Check if the old password matches
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'The old password does not match our records.');
        }
    
        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
