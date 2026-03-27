<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::query()->latest('tanggal')->latest('id')->get();

        return view('admin.berita.index', compact('data'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'penulis' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('berita', 'public');
        }

        Berita::create([
            'tanggal' => $validated['tanggal'],
            'penulis' => $validated['penulis'],
            'gambar' => $gambar,
            'judul' => $validated['judul'],
            'isi_berita' => $validated['isi_berita'],
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Berita::findOrFail($id);

        return view('admin.berita.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'penulis' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
        ]);

        $data = Berita::findOrFail($id);

        $gambar = $data->gambar;
        if ($request->hasFile('gambar')) {
            if ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
                Storage::disk('public')->delete($data->gambar);
            }
            $gambar = $request->file('gambar')->store('berita', 'public');
        }

        $data->update([
            'tanggal' => $validated['tanggal'],
            'penulis' => $validated['penulis'],
            'gambar' => $gambar,
            'judul' => $validated['judul'],
            'isi_berita' => $validated['isi_berita'],
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Berita::findOrFail($id);

        if ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
            Storage::disk('public')->delete($data->gambar);
        }

        $data->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus');
    }
}

