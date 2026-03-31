<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use App\Models\JadwalKegiatan;
use App\Models\Pengurus;
use App\Models\DataImam;
use App\Models\DonasiMasuk;
use App\Models\DonasiKeluar;
use App\Models\Donatur;
use App\Models\Berita;
use App\Models\Galeri;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // KAS
        $kasMasuk  = KasMasuk::orderBy('tanggal', 'desc')->limit(5)->get();
        $kasKeluar = KasKeluar::orderBy('tanggal', 'desc')->limit(5)->get();    
        $totalKasMasuk  = KasMasuk::sum('jumlah');
        $totalKasKeluar = KasKeluar::sum('nominal');

        // ANGGARAN KEGIATAN
        $totalAnggaranKegiatan = JadwalKegiatan::with('kasKeluar')
            ->whereNotNull('kas_keluar_id')
            ->get()
            ->sum(fn($k) => $k->kasKeluar->nominal ?? 0);

        // STAT KEGIATAN
        $totalJadwal  = JadwalKegiatan::whereDate('tanggal', '>=', now())->count();
        $statKegiatan = [
            'akan_datang' => JadwalKegiatan::whereDate('tanggal', '>', now())->count(),
            'hari_ini'    => JadwalKegiatan::whereDate('tanggal', Carbon::today())->count(),
            'selesai'     => JadwalKegiatan::whereDate('tanggal', '<', now())->count(),
        ];

        // KEGIATAN TERDEKAT
        $kegiatanTerdekat = JadwalKegiatan::with('kasKeluar')
            ->whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->limit(5)
            ->get();

        // PENGURUS
        $dataPengurus = Pengurus::orderBy('nama', 'asc')->limit(3)->get();
        $totalPengurus = Pengurus::count();

        // IMAM
        $totalImam   = DataImam::count();
        $dataImamList = DataImam::orderBy('nama', 'asc')->get();

        // DONASI
        $totalDonasiMasuk  = DonasiMasuk::get()->sum('nilai_dana');
        $totalDonasiKeluar = DonasiKeluar::get()->sum('nilai_dana');
        $jmlDonasiMasuk    = DonasiMasuk::count();
        $jmlDonasiKeluar   = DonasiKeluar::count();

        // DATA TERBARU DONASI
        $donasiMasukList  = DonasiMasuk::with('donatur')->orderBy('tanggal', 'desc')->limit(5)->get();
        $donasiKeluarList = DonasiKeluar::orderBy('tanggal', 'desc')->limit(5)->get();

        // DONATUR
        $totalDonatur = Donatur::count();
        $donaturList  = Donatur::orderBy('tanggal_daftar', 'desc')->limit(4)->get(); // untuk widget
        $dataDonatur  = Donatur::orderBy('tanggal_daftar', 'desc')->limit(10)->get(); // untuk tabel utama

        // KONTEN WEBSITE
        $totalBerita = Berita::count();
        $totalGaleri = Galeri::count();
        $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->limit(5)->get();
        $galeriTerbaru = Galeri::orderBy('tanggal', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'kasMasuk',
            'kasKeluar',
            'totalKasMasuk',
            'totalKasKeluar',
            'totalAnggaranKegiatan',
            'totalJadwal',
            'statKegiatan',
            'kegiatanTerdekat',
            'dataPengurus',
            'totalPengurus',
            'totalImam',
            'dataImamList',
            'totalDonasiMasuk',
            'totalDonasiKeluar',
            'jmlDonasiMasuk',
            'jmlDonasiKeluar',
            'donasiMasukList',
            'donasiKeluarList',
            'totalDonatur',
            'donaturList',
            'dataDonatur',
            'totalBerita',
            'totalGaleri',
            'beritaTerbaru',
            'galeriTerbaru'
        ));
    }
}
