<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymMembershipPackage;
use Exception;
use Illuminate\Http\Request;

class JenisMemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $edit = intval($request->input('edit', 0));
            $delete = intval($request->input('delete', 0));
            $data = $request->only('name', 'price', 'duration_in_days', 'personal_trainer_quota');
            if ($delete == 0) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric',
                    'duration_in_days' => 'required|integer',
                    'personal_trainer_quota' => 'required|integer',
                ]);
            }

            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    GymMembershipPackage::where('id', $id)->update($data);
                    return redirect()->route('admin_membership_package')->with('success', 'Data berhasil diperbarui!');
                } elseif ($delete == 1 && $id) {
                    GymMembershipPackage::where('id', $id)->delete();
                    return redirect()->route('admin_membership_package')->with('success', 'Data berhasil dihapus!');
                } else {
                    GymMembershipPackage::create($data);
                    return redirect()->route('admin_membership_package')->with('success', 'Data berhasil disimpan!');
                }
            } catch (Exception $e) {
                return redirect()->route('admin_membership_package')->with('error', 'Data gagal disimpan!');
            }
        }

        $packages = GymMembershipPackage::all();
        return view('admin.membership', compact('packages'));
    }
}
