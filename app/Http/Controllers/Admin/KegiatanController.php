<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKegiatan;
use App\Models\JadwalImam;
use App\Models\DataImam;
use App\Models\KasKeluar;

class KegiatanController extends Controller
{
    // ==================== JADWAL KEGIATAN ====================

    public function jadwal()
    {
        $kegiatan = JadwalKegiatan::with('kasKeluar')->orderBy('tanggal', 'asc')->get();
        return view('admin.kegiatan.jadwal_kegiatan', compact('kegiatan'));
    }

    public function jadwalCreate()
    {
        $kasKeluar = KasKeluar::orderBy('tanggal', 'desc')->get();
        return view('admin.kegiatan.jadwal_kegiatan_create', compact('kasKeluar'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'nama_kegiatan'    => 'required',
            'tanggal'          => 'required|date',
            'waktu'            => 'nullable',
            'tempat'           => 'nullable',
            'penanggung_jawab' => 'nullable',
            'keterangan'       => 'nullable',
            'kas_keluar_id'    => 'nullable|exists:kas_keluar,id',
        ]);

        JadwalKegiatan::create($request->all());

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Jadwal kegiatan berhasil ditambahkan');
    }

    public function jadwalEdit($id)
    {
        $kegiatan  = JadwalKegiatan::findOrFail($id);
        $kasKeluar = KasKeluar::orderBy('tanggal', 'desc')->get();
        return view('admin.kegiatan.jadwal_kegiatan_edit', compact('kegiatan', 'kasKeluar'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal'       => 'required|date',
            'kas_keluar_id' => 'nullable|exists:kas_keluar,id',
        ]);

        JadwalKegiatan::findOrFail($id)->update($request->all());

        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Jadwal kegiatan berhasil diupdate');
    }

    public function jadwalDelete($id)
    {
        JadwalKegiatan::findOrFail($id)->delete();
        return redirect()->route('kegiatan.jadwal')
            ->with('success', 'Jadwal kegiatan berhasil dihapus');
    }

    // ==================== DATA IMAM ====================

    public function imamData()
    {
        $imam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.data_imam_index', compact('imam'));
    }

    public function imamDataCreate()
    {
        return view('admin.kegiatan.data_imam_create');
    }

    public function imamDataStore(Request $request)
    {
        $request->validate(['nama' => 'required', 'status' => 'required|in:Tetap,Tamu']);
        DataImam::create($request->all());
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil ditambahkan');
    }

    public function imamDataEdit($id)
    {
        $imam = DataImam::findOrFail($id);
        return view('admin.kegiatan.data_imam_edit', compact('imam'));
    }

    public function imamDataUpdate(Request $request, $id)
    {
        $request->validate(['nama' => 'required', 'status' => 'required|in:Tetap,Tamu']);
        DataImam::findOrFail($id)->update($request->all());
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil diupdate');
    }

    public function imamDataDelete($id)
    {
        DataImam::findOrFail($id)->delete();
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil dihapus');
    }

    // ==================== JADWAL IMAM ====================

    public function imam()
    {
        $imam     = JadwalImam::with('imam')->orderBy('tanggal', 'asc')->get();
        $dataImam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.jadwal_imam', compact('imam', 'dataImam'));
    }

    public function imamCreate()
    {
        $dataImam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.jadwal_imam_create', compact('dataImam'));
    }

    public function imamStore(Request $request)
    {
        $request->validate([
            'imam_id'      => 'required|exists:data_imam,id',
            'tanggal'      => 'required|date',
            'hari'         => 'nullable',
            'waktu_sholat' => 'required',
            'keterangan'   => 'nullable',
        ]);
        JadwalImam::create($request->all());
        return redirect()->route('kegiatan.imam')->with('success', 'Jadwal imam berhasil ditambahkan');
    }

    public function imamEdit($id)
    {
        $jadwal   = JadwalImam::findOrFail($id);
        $dataImam = DataImam::orderBy('nama', 'asc')->get();
        return view('admin.kegiatan.jadwal_imam_edit', compact('jadwal', 'dataImam'));
    }

    public function imamUpdate(Request $request, $id)
    {
        $request->validate([
            'imam_id'      => 'required|exists:data_imam,id',
            'tanggal'      => 'required|date',
            'waktu_sholat' => 'required',
        ]);
        JadwalImam::findOrFail($id)->update($request->all());
        return redirect()->route('kegiatan.imam')->with('success', 'Jadwal imam berhasil diupdate');
    }

    public function imamDelete($id)
    {
        JadwalImam::findOrFail($id)->delete();
        return redirect()->route('kegiatan.imam')->with('success', 'Jadwal imam berhasil dihapus');
    }

    // ==================== JADWAL SHOLAT ====================

    public function sholat()
    {
        return view('admin.kegiatan.jadwal_sholat');
    }
}
