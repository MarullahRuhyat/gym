<?php

namespace App\Http\Controllers\PersonalTraining;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
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
    
        $data_user = User::find(Auth::user()->id);
    
        // Handle the file upload
        if ($request->hasFile('photo_profile')) {
            $file = $request->file('photo_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images/avatars'), $fileName);
    
            // Delete the old photo if it exists
            if ($data_user->photo_profile && file_exists(public_path('assets/images/avatars/' . $data_user->photo_profile))) {
                unlink(public_path('assets/images/avatars/' . $data_user->photo_profile));
            }    
            $data_user->photo_profile = $fileName;
        }
    
        // Update the rest of the user's profile
        $data_user->name = $request->name;
        $data_user->email = $request->email;
        $data_user->phone_number = $request->phone;
        $data_user->save();
    
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
