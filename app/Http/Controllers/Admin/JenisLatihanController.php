<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLatihan;
use Exception;
use Illuminate\Http\Request;

class JenisLatihanController extends Controller
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
            $data = $request->only('name');
            try {
                $id = $request->input('id', 0);

                if ($edit == 1 && $id) {
                    JenisLatihan::where('id', $id)->update($data);
                    return redirect()->route('admin_jenis_latihan')->with('success', 'Data berhasil diperbarui!');
                } elseif ($delete == 1 && $id) {
                    JenisLatihan::where('id', $id)->delete();
                    return redirect()->route('admin_jenis_latihan')->with('success', 'Data berhasil dihapus!');
                } else {
                    JenisLatihan::create($data);
                    return redirect()->route('admin_jenis_latihan')->with('success', 'Data berhasil disimpan!');
                }
            } catch (Exception $e) {
                return redirect()->route('admin_jenis_latihan')->with('error', 'Data gagal disimpan!');
            }
        }

        $jenis_latihan = JenisLatihan::all();
        return view('admin.jenis_latihan', compact('jenis_latihan'));
    }
}
