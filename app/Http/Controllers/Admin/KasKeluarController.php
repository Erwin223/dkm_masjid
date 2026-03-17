<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasKeluar;

class KasKeluarController extends Controller
{
    public function create()
    {
        return view('admin.kas_keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_pengeluaran' => 'required',
            'jumlah' => 'required|numeric',
            'nominal' => 'required|numeric',
            'keterangan'=> 'nullable',
        ]);

        KasKeluar::create([
            'tanggal' => $request->tanggal,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'jumlah' => $request->jumlah,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Kas keluar berhasil ditambahkan');
    }
    public function edit($id)
{
    $data = KasKeluar::findOrFail($id);
    return view('admin.kas_keluar.edit', compact('data'));
}
// UPDATE
public function update(Request $request, $id)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jenis_pengeluaran' => 'required',
        'jumlah' => 'required|numeric',
        'nominal' => 'required',
    ]);

    $nominal = str_replace('.', '', $request->nominal);

    $data = KasKeluar::findOrFail($id);
    $data->update([
        'tanggal' => $request->tanggal,
        'jenis_pengeluaran' => $request->jenis_pengeluaran,
        'jumlah' => $request->jumlah,
        'nominal' => $nominal,
        'keterangan' => $request->keterangan,
    ]);

    return redirect()->route('admin.dashboard')
        ->with('success','Data kas keluar berhasil diupdate');
}

// DELETE
public function destroy($id)
{
    KasKeluar::findOrFail($id)->delete();

    return redirect()->route('admin.dashboard')
        ->with('success','Data berhasil dihapus');
}
}

