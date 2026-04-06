<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donatur;

class DonaturController extends Controller
{
    public function index()
    {
        $data = Donatur::orderBy('nama', 'asc')->get();
        return view('admin.donatur.index', compact('data'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'           => 'required',
            'no_hp'          => 'nullable',
            'email'          => 'nullable|email',
            'alamat'         => 'nullable',
            'jenis_donatur'  => 'required|in:Individu,Lembaga',
            'tanggal_daftar' => 'required|date',
        ]);

        Donatur::create($validated);

        return redirect()->route('donatur.index')
            ->with('success', 'Data donatur berhasil ditambahkan');
    }

    public function edit($id)
    {
        $donatur = Donatur::findOrFail($id);
        return view('admin.donatur.edit', compact('donatur'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama'          => 'required',
            'no_hp'         => 'nullable',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable',
            'jenis_donatur' => 'required|in:Individu,Lembaga',
            'tanggal_daftar'=> 'required|date',
        ]);

        Donatur::findOrFail($id)->update($validated);

        return redirect()->route('donatur.index')
            ->with('success', 'Data donatur berhasil diupdate');
    }

    public function delete($id)
    {
        Donatur::findOrFail($id)->delete();

        return redirect()->route('donatur.index')
            ->with('success', 'Data donatur berhasil dihapus');
    }

    // API untuk autocomplete / dropdown di form donasi
    public function list()
    {
        $data = Donatur::orderBy('nama', 'asc')
            ->select('id', 'nama', 'no_hp', 'jenis_donatur')
            ->get();
        return response()->json($data);
    }
}
