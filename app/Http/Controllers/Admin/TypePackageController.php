<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypePackage;
use Exception;
use Illuminate\Http\Request;

class TypePackageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // Handle POST request
            $edit = intval($request->input('edit', 0));
            $delete = intval($request->input('delete', 0));
            if ($delete == 0) {
                $request->validate([
                    'name' => 'required|string|max:255',
                ]);
            }
            $data = $request->only('name', 'max_user', 'bonus');
            // Memperbaiki format bonus
            if (isset($data['bonus'])) {
                $data['bonus'] = str_replace('.', '', $data['bonus']);
            }
            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    TypePackage::where('id', $id)->update($data);
                    return redirect()->route('admin_type_package')->with('success', 'Data berhasil diperbarui!');
                } elseif ($delete == 1 && $id) {
                    TypePackage::where('id', $id)->delete();
                    return redirect()->route('admin_type_package')->with('success', 'Data berhasil dihapus!');
                } else {
                    TypePackage::create($data);
                    return redirect()->route('admin_type_package')->with('success', 'Data berhasil disimpan!');
                }
            } catch (Exception $e) {
                return redirect()->route('admin_type_package')->with('error', 'Data gagal disimpan!');
            }
        }

        $perPage = 1;
        $type_package = TypePackage::query();
        $page = $request->query('page', 1);
        $name = $request->query('name', '');
        if ($name != '') {
            $type_package->where('name', 'LIKE', '%' . $name . '%');
        }
        $results = $type_package->paginate($perPage, ['*'], 'page', $page);
        $total_page = intval(ceil($results->total() / $results->perPage()));

        if ($request->ajax()) {
            return view('admin.type_package.data', compact('results', 'total_page'))->render();
        }

        $type_package = TypePackage::all();
        return view('admin.type_package.index', compact('results', 'total_page'));
    }
}
