<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use Carbon\Carbon;

class KegiatanController extends Controller
{
    /**
     * Menampilkan halaman jadwal kegiatan frontend
     */
    public function index()
    {
        $today = Carbon::today();

        // Ambil semua kegiatan yang sudah disetujui, diurutkan berdasarkan tanggal
        $jadwal_kegiatan = JadwalKegiatan::query()
            ->where('status', 'approved')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function (JadwalKegiatan $kegiatan) {
                return [
                    'id' => $kegiatan->id,
                    'nama_kegiatan' => $kegiatan->nama_kegiatan,
                    'tanggal' => $kegiatan->tanggal,
                    'waktu' => $kegiatan->waktu,
                    'tempat' => $kegiatan->tempat,
                    'penanggung_jawab' => $kegiatan->penanggung_jawab,
                    'keterangan' => $kegiatan->keterangan,
                    'status' => $kegiatan->status,
                    'approved_at' => $kegiatan->approved_at,
                ];
            })
            ->toArray();

        return view('frontend.kegiatan.index', [
            'jadwal_kegiatan' => $jadwal_kegiatan,
        ]);
    }
}
