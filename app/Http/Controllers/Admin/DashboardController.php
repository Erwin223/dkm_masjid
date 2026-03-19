<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\JadwalKegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $kasMasuk       = KasMasuk::orderBy('tanggal', 'desc')->get();
        $kasKeluar      = KasKeluar::orderBy('tanggal', 'desc')->get();
        $totalKasMasuk  = KasMasuk::sum('jumlah');
        $totalKasKeluar = KasKeluar::sum('nominal');

        // Total anggaran kegiatan = sum nominal kas keluar yang terhubung ke kegiatan
        $totalAnggaranKegiatan = JadwalKegiatan::with('kasKeluar')
            ->whereNotNull('kas_keluar_id')
            ->get()
            ->sum(fn($k) => $k->kasKeluar->nominal ?? 0);

        // Jumlah kegiatan yang akan datang
        $totalJadwal = JadwalKegiatan::whereDate('tanggal', '>=', now())->count();

        return view('admin.dashboard', compact(
            'kasMasuk',
            'kasKeluar',
            'totalKasMasuk',
            'totalKasKeluar',
            'totalAnggaranKegiatan',
            'totalJadwal',
        ));
    }
}
