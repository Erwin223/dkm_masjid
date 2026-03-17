<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasMasuk;

class KasMasukController extends Controller
{
    public function create()
    {
        return view('admin.kas_masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable'
        ]);

          $jumlah = str_replace('.', '', $request->jumlah);

    KasMasuk::create([
        'tanggal' => $request->tanggal,
        'sumber' => $request->sumber,
        'jumlah' => $jumlah,
        'keterangan' => $request->keterangan,
    ]);



        return redirect()->route('admin.dashboard')
            ->with('success','Data kas masuk berhasil ditambahkan');

    }

    public function delete ($id)
    {
        $data = KasMasuk::findOrFail($id);
    $data->delete();

    return redirect()->route('admin.dashboard')
        ->with('success', 'Data kas masuk berhasil dihapus');
    }
    public function edit($id)
    {
        $data = KasMasuk::findOrFail($id);
        return view('admin.kas_masuk.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable'
        ]);

        $data = KasMasuk::findOrFail($id);
        $jumlah = str_replace('.', '', $request->jumlah);

        $data->update([
            'tanggal' => $request->tanggal,
            'sumber' => $request->sumber,
            'jumlah' => $jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Data kas masuk berhasil diperbarui');
    }

}
