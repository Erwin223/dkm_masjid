<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $data = Galeri::orderBy('tanggal', 'desc')->get();
        return view('admin.galeri.index', compact('data'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = Galeri::findOrFail($id);
        $gambar = $data->gambar;

        if ($request->hasFile('gambar')) {
            if ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
                Storage::disk('public')->delete($data->gambar);
            }
            $gambar = $request->file('gambar')->store('galeri', 'public');
        }

        $data->update([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil diupdate');
    }

    public function delete($id)
    {
        $data = Galeri::findOrFail($id);

        if ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
            Storage::disk('public')->delete($data->gambar);
        }

        $data->delete();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus');
    }
}
