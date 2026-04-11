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
        $request->merge([
            'estimasi_anggaran' => $this->normalizeCurrencyInput($request->input('estimasi_anggaran')),
        ]);

        $validated = $request->validate([
            'nama_kegiatan'    => 'required',
            'tanggal'          => 'required|date',
            'waktu'            => 'nullable',
            'tempat'           => 'nullable',
            'penanggung_jawab' => 'nullable',
            'estimasi_anggaran'=> 'nullable|numeric|min:0',
            'keterangan'       => 'nullable',
            'kas_keluar_id'    => 'nullable|exists:kas_keluar,id',
        ]);

        JadwalKegiatan::create($validated);

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
        $request->merge([
            'estimasi_anggaran' => $this->normalizeCurrencyInput($request->input('estimasi_anggaran')),
        ]);

        $validated = $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal'       => 'required|date',
            'waktu'         => 'nullable',
            'tempat'        => 'nullable',
            'penanggung_jawab' => 'nullable',
            'estimasi_anggaran' => 'nullable|numeric|min:0',
            'keterangan'    => 'nullable',
            'kas_keluar_id' => 'nullable|exists:kas_keluar,id',
        ]);

        JadwalKegiatan::findOrFail($id)->update($validated);

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
        $validated = $request->validate(['nama' => 'required', 'status' => 'required|in:Tetap,Tamu']);
        DataImam::create($validated);
        return redirect()->route('imam.data')->with('success', 'Data imam berhasil ditambahkan');
    }

    public function imamDataEdit($id)
    {
        $imam = DataImam::findOrFail($id);
        return view('admin.kegiatan.data_imam_edit', compact('imam'));
    }

    public function imamDataUpdate(Request $request, $id)
    {
        $validated = $request->validate(['nama' => 'required', 'status' => 'required|in:Tetap,Tamu']);
        DataImam::findOrFail($id)->update($validated);
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
        $validated = $request->validate([
            'imam_id'      => 'required|exists:data_imam,id',
            'tanggal'      => 'required|date',
            'hari'         => 'nullable',
            'waktu_sholat' => 'required',
            'keterangan'   => 'nullable',
        ]);
        JadwalImam::create($validated);
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
        $validated = $request->validate([
            'imam_id'      => 'required|exists:data_imam,id',
            'tanggal'      => 'required|date',
            'hari'         => 'nullable',
            'waktu_sholat' => 'required',
            'keterangan'   => 'nullable',
        ]);
        JadwalImam::findOrFail($id)->update($validated);
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

    private function normalizeCurrencyInput(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = preg_replace('/[^\d]/', '', $value);

        return $normalized === '' ? null : $normalized;
    }
}
