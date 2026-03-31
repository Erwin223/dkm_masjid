<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KasKeluar;
use Carbon\Carbon;

class KasKeluarController extends Controller
{
    public function index()
    {
        $data            = KasKeluar::orderBy('tanggal', 'desc')->get();
        $totalKeluar     = KasKeluar::sum('nominal');
        $keluarBulanIni  = KasKeluar::whereMonth('tanggal', Carbon::now()->month)
                               ->whereYear('tanggal', Carbon::now()->year)
                               ->sum('nominal');
        $jmlBulanIni     = KasKeluar::whereMonth('tanggal', Carbon::now()->month)
                               ->whereYear('tanggal', Carbon::now()->year)
                               ->count();

        return view('admin.kas_keluar.index', compact(
            'data', 'totalKeluar', 'keluarBulanIni', 'jmlBulanIni'
        ));
    }

    public function create()
    {
        return view('admin.kas_keluar.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'nominal' => str_replace('.', '', (string) $request->nominal),
        ]);

        $request->validate([
            'tanggal'           => 'required|date',
            'jenis_pengeluaran' => 'required',
            'nominal'           => 'required|numeric',
            'keterangan'        => 'nullable',
        ]);

        KasKeluar::create([
            'tanggal'           => $request->tanggal,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'nominal'           => $request->nominal,
            'keterangan'        => $request->keterangan,
        ]);

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Kas keluar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = KasKeluar::findOrFail($id);
        return view('admin.kas_keluar.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'nominal' => str_replace('.', '', (string) $request->nominal),
        ]);

        $request->validate([
            'tanggal'           => 'required|date',
            'jenis_pengeluaran' => 'required',
            'nominal'           => 'required|numeric',
            'keterangan'        => 'nullable',
        ]);

        KasKeluar::findOrFail($id)->update([
            'tanggal'           => $request->tanggal,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'nominal'           => $request->nominal,
            'keterangan'        => $request->keterangan,
        ]);

        return redirect()->route('kas.keluar.index')
            ->with('success', 'Data kas keluar berhasil diupdate');
    }

    public function destroy($id)
    {
        KasKeluar::findOrFail($id)->delete();
        return redirect()->route('kas.keluar.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
