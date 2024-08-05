<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GymMembershipPackage;
use App\Models\TypePackage;
use Exception;
use Illuminate\Http\Request;

class JenisMemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $edit = intval($request->input('edit', 0));
            $delete = intval($request->input('delete', 0));
            $data = $request->only('name', 'price', 'duration_in_days', 'personal_trainer_quota', 'type_packages_id');
            if ($delete == 0) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric',
                    'duration_in_days' => 'required|integer',
                    'personal_trainer_quota' => 'required|integer',
                    'type_packages_id' => 'required|integer',
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

        $perPage = 10;
        $membership = GymMembershipPackage::query()
            ->leftJoin('type_packages', 'gym_membership_packages.type_packages_id', '=', 'type_packages.id')
            ->select('gym_membership_packages.*', 'type_packages.name as type_package_name');
        $page = $request->query('page', 1);
        $name = $request->query('name', '');
        if ($name != '') {
            $membership->where('name', 'LIKE', '%' . $name . '%');
        }
        $results = $membership->paginate($perPage, ['*'], 'page', $page);
        $total_page = intval(ceil($results->total() / $results->perPage()));

        $type_packages = TypePackage::all();

        if ($request->ajax()) {
            return view('admin.membership.data', compact('results', 'total_page'))->render();
        }
        return view('admin.membership.index', compact('results', 'total_page', 'type_packages'));
    }
}
