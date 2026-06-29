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
        $data = Berita::query()->latest('tanggal')->latest('id')->paginate(5);

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
            'gambar.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
        ]);

        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambarPaths[] = $file->store('berita', 'public');
            }
        }

        Berita::create([
            'tanggal' => $validated['tanggal'],
            'penulis' => $validated['penulis'],
            'gambar' => !empty($gambarPaths) ? $gambarPaths : null,
            'judul' => $validated['judul'],
            'sinopsis' => $validated['sinopsis'] ?? null,
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
            'gambar.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'judul' => 'required|string|max:255',
            'sinopsis' => 'nullable|string|max:500',
            'isi_berita' => 'required|string',
        ]);

        $data = Berita::findOrFail($id);

        $gambarPaths = $data->gambar;
        if ($request->hasFile('gambar')) {
            if (is_array($data->gambar)) {
                foreach ($data->gambar as $oldPath) {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            } elseif ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
                Storage::disk('public')->delete($data->gambar);
            }
            
            $gambarPaths = [];
            foreach ($request->file('gambar') as $file) {
                $gambarPaths[] = $file->store('berita', 'public');
            }
        }

        $data->update([
            'tanggal' => $validated['tanggal'],
            'penulis' => $validated['penulis'],
            'gambar' => $gambarPaths,
            'judul' => $validated['judul'],
            'sinopsis' => $validated['sinopsis'] ?? null,
            'isi_berita' => $validated['isi_berita'],
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate');
    }

    public function destroy($id)
    {
        $data = Berita::findOrFail($id);

        if (is_array($data->gambar)) {
            foreach ($data->gambar as $oldPath) {
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        } elseif ($data->gambar && Storage::disk('public')->exists($data->gambar)) {
            Storage::disk('public')->delete($data->gambar);
        }

        $data->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus');
    }
}

