<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonasiMasuk;
use App\Models\DonasiKeluar;
use App\Models\Donatur;

class DonasiController extends Controller
{
    // ==================== DONASI MASUK ====================

    public function masuk()
    {
        $data       = DonasiMasuk::with('donatur')->orderBy('tanggal', 'desc')->get();
        $totalMasuk = DonasiMasuk::sum('total');
        return view('admin.donasi.donasi_masuk_index', compact('data', 'totalMasuk'));
    }

    public function masukCreate()
    {
        $donaturList = Donatur::orderBy('nama', 'asc')->get();
        return view('admin.donasi.donasi_masuk_create', compact('donaturList'));
    }

    public function masukStore(Request $request)
    {
        $request->validate([
            'tanggal'         => 'required|date',
            'donatur_id'      => 'nullable|exists:donatur,id',
            'donatur_nama'    => 'nullable|string',
            'jenis_donasi'    => 'required',
            'kategori_donasi' => 'required',
            'jumlah'          => 'required|numeric|min:0',
            'keterangan'      => 'nullable',
        ]);

        // Tentukan nama donatur
        if ($request->donatur_id) {
            $namaDonatur = Donatur::find($request->donatur_id)->nama;
        } else {
            $namaDonatur = $request->donatur_nama ?: 'Hamba Allah';
        }

        DonasiMasuk::create([
            'donatur_id'      => $request->donatur_id ?: null,
            'donatur_nama'    => $namaDonatur,
            'tanggal'         => $request->tanggal,
            'jenis_donasi'    => $request->jenis_donasi,
            'kategori_donasi' => $request->kategori_donasi,
            'jumlah'          => $request->jumlah,
            'total'           => $request->jumlah, // total = jumlah otomatis
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('donasi.masuk')
            ->with('success', 'Data donasi masuk berhasil ditambahkan');
    }

    public function masukEdit($id)
    {
        $donasi      = DonasiMasuk::findOrFail($id);
        $donaturList = Donatur::orderBy('nama', 'asc')->get();
        return view('admin.donasi.donasi_masuk_edit', compact('donasi', 'donaturList'));
    }

    public function masukUpdate(Request $request, $id)
    {
        $request->validate([
            'tanggal'         => 'required|date',
            'donatur_id'      => 'nullable|exists:donatur,id',
            'donatur_nama'    => 'nullable|string',
            'jenis_donasi'    => 'required',
            'kategori_donasi' => 'required',
            'jumlah'          => 'required|numeric|min:0',
        ]);

        if ($request->donatur_id) {
            $namaDonatur = Donatur::find($request->donatur_id)->nama;
        } else {
            $namaDonatur = $request->donatur_nama ?: 'Hamba Allah';
        }

        DonasiMasuk::findOrFail($id)->update([
            'donatur_id'      => $request->donatur_id ?: null,
            'donatur_nama'    => $namaDonatur,
            'tanggal'         => $request->tanggal,
            'jenis_donasi'    => $request->jenis_donasi,
            'kategori_donasi' => $request->kategori_donasi,
            'jumlah'          => $request->jumlah,
            'total'           => $request->jumlah, // total = jumlah otomatis
            'keterangan'      => $request->keterangan,
        ]);

        return redirect()->route('donasi.masuk')
            ->with('success', 'Data donasi masuk berhasil diupdate');
    }

    public function masukDelete($id)
    {
        DonasiMasuk::findOrFail($id)->delete();
        return redirect()->route('donasi.masuk')
            ->with('success', 'Data donasi masuk berhasil dihapus');
    }

    // ==================== DONASI KELUAR ====================

    public function keluar()
    {
        $data        = DonasiKeluar::orderBy('tanggal', 'desc')->get();
        $totalKeluar = DonasiKeluar::sum('jumlah');
        return view('admin.donasi.donasi_keluar_index', compact('data', 'totalKeluar'));
    }

    public function keluarCreate()
    {
        return view('admin.donasi.donasi_keluar_create');
    }

    public function keluarStore(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'jenis_donasi' => 'required',
            'tujuan'       => 'required',
            'jumlah'       => 'required|numeric|min:0',
            'keterangan'   => 'nullable',
        ]);

        DonasiKeluar::create($request->all());

        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil ditambahkan');
    }

    public function keluarEdit($id)
    {
        $donasi = DonasiKeluar::findOrFail($id);
        return view('admin.donasi.donasi_keluar_edit', compact('donasi'));
    }

    public function keluarUpdate(Request $request, $id)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'jenis_donasi' => 'required',
            'tujuan'       => 'required',
            'jumlah'       => 'required|numeric|min:0',
        ]);

        DonasiKeluar::findOrFail($id)->update($request->all());

        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil diupdate');
    }

    public function keluarDelete($id)
    {
        DonasiKeluar::findOrFail($id)->delete();
        return redirect()->route('donasi.keluar')
            ->with('success', 'Data donasi keluar berhasil dihapus');
    }
}
