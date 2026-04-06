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
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\PenerimaanZakat;
use App\Models\DistribusiZakat;
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
        $allDonasiMasuk = DonasiMasuk::query()->get();
        $allDonasiKeluar = DonasiKeluar::query()->get();
        $totalDonasiMasuk  = $this->sumDonasiMasuk($allDonasiMasuk);
        $totalDonasiKeluar = $this->sumDonasiKeluar($allDonasiKeluar);
        $jmlDonasiMasuk    = $allDonasiMasuk->count();
        $jmlDonasiKeluar   = $allDonasiKeluar->count();
        $ringkasanDonasiMasuk = $this->summarizeDonasiMasuk($allDonasiMasuk);
        $ringkasanDonasiKeluar = $this->summarizeDonasiKeluar($allDonasiKeluar);

        // DATA TERBARU DONASI
        $donasiMasukList  = DonasiMasuk::with('donatur')->orderBy('tanggal', 'desc')->limit(5)->get();
        $donasiKeluarList = DonasiKeluar::orderBy('tanggal', 'desc')->limit(5)->get();

        $latestDonasiMasuk  = $donasiMasukList->first();
        $latestDonasiKeluar = $donasiKeluarList->first();

        // ZAKAT
        $penerimaanZakatList = PenerimaanZakat::with('muzakki')->orderBy('tanggal', 'desc')->limit(5)->get();
        $distribusiZakatList = DistribusiZakat::with('mustahik')->orderBy('tanggal', 'desc')->limit(5)->get();

        $latestPenerimaanZakat = $penerimaanZakatList->first();
        $latestDistribusiZakat = $distribusiZakatList->first();

        $allPenerimaanZakat = PenerimaanZakat::query()->get();
        $allDistribusiZakat = DistribusiZakat::query()->get();
        $totalZakatMasuk = $this->sumPenerimaanZakat($allPenerimaanZakat);
        $totalZakatKeluar = $this->sumDistribusiZakat($allDistribusiZakat);
        $jmlPenerimaanZakat = $allPenerimaanZakat->count();
        $jmlDistribusiZakat = $allDistribusiZakat->count();
        $ringkasanPenerimaanZakat = $this->summarizePenerimaanZakat($allPenerimaanZakat);
        $ringkasanDistribusiZakat = $this->summarizeDistribusiZakat($allDistribusiZakat);
        $totalMuzakki = Muzakki::count();
        $totalMustahik = Mustahik::count();

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
            'ringkasanDonasiMasuk',
            'ringkasanDonasiKeluar',
            'latestDonasiMasuk',
            'latestDonasiKeluar',
            'penerimaanZakatList',
            'distribusiZakatList',
            'ringkasanPenerimaanZakat',
            'ringkasanDistribusiZakat',
            'latestPenerimaanZakat',
            'latestDistribusiZakat',
            'totalZakatMasuk',
            'totalZakatKeluar',
            'jmlPenerimaanZakat',
            'jmlDistribusiZakat',
            'totalMuzakki',
            'totalMustahik',
            'totalDonatur',
            'donaturList',
            'dataDonatur',
            'totalBerita',
            'totalGaleri',
            'beritaTerbaru',
            'galeriTerbaru'
        ));
    }
    private function sumDonasiMasuk($items): float
    {
        return $items->sum(function (DonasiMasuk $item): float {
            return (float) ($item->total ?? 0);
        });
    }

    private function sumDonasiKeluar($items): float
    {
        return $items->sum(function (DonasiKeluar $item): float {
            return (float) $item->nilai_dana;
        });
    }

    private function sumPenerimaanZakat($items): float
    {
        return $items->sum(function (PenerimaanZakat $item): float {
            return $item->is_barang
                ? (float) ($item->nominal ?? 0)
                : (float) ($item->nominal ?? $item->jumlah_zakat ?? 0);
        });
    }

    private function sumDistribusiZakat($items): float
    {
        return $items->sum(function (DistribusiZakat $item): float {
            return $item->is_barang
                ? (float) ($item->nominal ?? 0)
                : (float) ($item->nominal ?? $item->jumlah_zakat ?? 0);
        });
    }

    private function summarizeDonasiMasuk($items): array
    {
        $barang = $items->filter(fn (DonasiMasuk $item) => $item->is_barang);
        $uang = $items->reject(fn (DonasiMasuk $item) => $item->is_barang);

        return [
            'uang_total' => $uang->sum(fn (DonasiMasuk $item) => (float) $item->nilai_dana),
            'uang_count' => $uang->count(),
            'barang_count' => $barang->count(),
            'barang_preview' => $this->previewLabels($barang->map(fn (DonasiMasuk $item) => $item->label_jumlah)),
            'kategori_count' => $items->pluck('kategori_donasi')->filter()->unique()->count(),
        ];
    }

    private function summarizeDonasiKeluar($items): array
    {
        $barang = $items->filter(fn (DonasiKeluar $item) => $item->is_barang);
        $uang = $items->reject(fn (DonasiKeluar $item) => $item->is_barang);

        return [
            'uang_total' => $uang->sum(fn (DonasiKeluar $item) => (float) $item->nilai_dana),
            'uang_count' => $uang->count(),
            'barang_count' => $barang->count(),
            'barang_preview' => $this->previewLabels($barang->map(fn (DonasiKeluar $item) => $item->label_jumlah)),
            'tujuan_count' => $items->pluck('tujuan')->filter()->unique()->count(),
        ];
    }

    private function summarizePenerimaanZakat($items): array
    {
        $barang = $items->filter(fn (PenerimaanZakat $item) => $item->is_barang);
        $uang = $items->reject(fn (PenerimaanZakat $item) => $item->is_barang);

        return [
            'uang_total' => $uang->sum(fn (PenerimaanZakat $item) => (float) $item->nilai_dana),
            'uang_count' => $uang->count(),
            'barang_count' => $barang->count(),
            'barang_preview' => $this->previewLabels($barang->map(fn (PenerimaanZakat $item) => $item->label_jumlah)),
            'total_jiwa' => $items->sum(fn (PenerimaanZakat $item) => (int) ($item->jumlah_tanggungan ?? 0)),
            'fitrah_uang_count' => $items->filter(fn (PenerimaanZakat $item) => $item->is_fitrah_uang)->count(),
        ];
    }

    private function summarizeDistribusiZakat($items): array
    {
        $barang = $items->filter(fn (DistribusiZakat $item) => $item->is_barang);
        $uang = $items->reject(fn (DistribusiZakat $item) => $item->is_barang);

        return [
            'uang_total' => $uang->sum(fn (DistribusiZakat $item) => (float) $item->nilai_dana),
            'uang_count' => $uang->count(),
            'barang_count' => $barang->count(),
            'barang_preview' => $this->previewLabels($barang->map(fn (DistribusiZakat $item) => $item->label_jumlah)),
            'jenis_count' => $items->pluck('jenis_zakat')->filter()->unique()->count(),
        ];
    }

    private function previewLabels($labels): string
    {
        $items = $labels
            ->filter(fn ($label) => filled($label) && $label !== '-')
            ->unique()
            ->take(2)
            ->values();

        if ($items->isEmpty()) {
            return 'dicatat sebagai barang sesuai satuan';
        }

        return $items->implode(', ');
    }
}
