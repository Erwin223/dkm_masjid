<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengurus;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    // =======================
    // LIST DATA
    // =======================
    public function index()
    {
      $data = Pengurus::select('id','nama','jabatan','no_hp','foto')->get();
        return view('admin.pengurus.index', compact('data'));
    }

    // =======================
    // FORM CREATE
    // =======================
    public function create()
    {
        return view('admin.pengurus.create');
    }

    // =======================
    // SIMPAN DATA
    // =======================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $foto = null;

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pengurus', 'public');
        }

        Pengurus::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'foto' => $foto
        ]);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // =======================
    // FORM EDIT
    // =======================
    public function edit($id)
    {
        $data = Pengurus::findOrFail($id);
        return view('admin.pengurus.edit', compact('data'));
    }

    // =======================
    // UPDATE DATA
    // =======================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = Pengurus::findOrFail($id);

        $foto = $data->foto;

        // JIKA ADA FOTO BARU
        if ($request->hasFile('foto')) {

            // HAPUS FOTO LAMA
            if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                Storage::disk('public')->delete($data->foto);
            }

            // SIMPAN FOTO BARU
            $foto = $request->file('foto')->store('pengurus', 'public');
        }

        $data->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'foto' => $foto
        ]);

        return redirect()->route('pengurus.index')
            ->with('success', 'Data berhasil diupdate');
    }

    // =======================
    // HAPUS DATA
    // =======================
    public function destroy($id)
    {
        $data = Pengurus::findOrFail($id);

        // HAPUS FOTO JIKA ADA
        if ($data->foto && Storage::disk('public')->exists($data->foto)) {
            Storage::disk('public')->delete($data->foto);
        }

        $data->delete();

        return redirect()->route('pengurus.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
