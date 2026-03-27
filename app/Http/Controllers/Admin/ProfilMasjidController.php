<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilMasjid;
use Illuminate\Http\Request;

class ProfilMasjidController extends Controller
{
    public function index()
    {
        $profil = ProfilMasjid::query()->latest('id')->first();

        return view('admin.profil_masjid.index', compact('profil'));
    }

    public function create()
    {
        $profil = ProfilMasjid::query()->latest('id')->first();
        if ($profil) {
            return redirect()->route('profil_masjid.edit', $profil->id);
        }

        return view('admin.profil_masjid.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'alamat' => 'required|string',
        ]);

        ProfilMasjid::create($validated);

        return redirect()->route('profil_masjid.index')->with('success', 'Profil masjid berhasil disimpan');
    }

    public function edit($id)
    {
        $profil = ProfilMasjid::findOrFail($id);

        return view('admin.profil_masjid.edit', compact('profil'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $profil = ProfilMasjid::findOrFail($id);
        $profil->update($validated);

        return redirect()->route('profil_masjid.index')->with('success', 'Profil masjid berhasil diupdate');
    }
}

