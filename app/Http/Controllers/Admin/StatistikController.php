<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiMasuk;
use App\Models\PenerimaanZakat;
use App\Models\KasMasuk;
use App\Models\KasKeluar;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        // === Tren Donasi & Zakat per Bulan (6 bulan terakhir) ===
        $bulanList = [];
        $donasiPerBulan = [];
        $zakatPerBulan = [];
        $kasMasukPerBulan = [];
        $kasKeluarPerBulan = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan = $date->month;
            $tahun = $date->year;
            $bulanList[] = $date->translatedFormat('M Y') ?: $date->format('M Y');

            $donasiPerBulan[] = (float) DonasiMasuk::whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('total');

            $zakatPerBulan[] = (float) PenerimaanZakat::whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('nominal');

            $kasMasukPerBulan[] = (float) KasMasuk::whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('jumlah');

            $kasKeluarPerBulan[] = (float) KasKeluar::whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('nominal');
        }

        // === Donasi per Kategori ===
        $donasiKategori = DonasiMasuk::select('kategori_donasi', DB::raw('SUM(total) as total'))
            ->groupBy('kategori_donasi')
            ->orderByDesc('total')
            ->get();

        $donasiKategoriLabel = $donasiKategori->pluck('kategori_donasi')->map(fn($k) => ucfirst($k ?? ''))->toArray();
        $donasiKategoriData  = $donasiKategori->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // === Zakat per Jenis ===
        $zakatJenis = PenerimaanZakat::select('jenis_zakat', DB::raw('SUM(nominal) as total'))
            ->groupBy('jenis_zakat')
            ->orderByDesc('total')
            ->get();

        $zakatJenisLabel = $zakatJenis->pluck('jenis_zakat')->map(fn($k) => ucwords(str_replace('_', ' ', $k)))->toArray();
        $zakatJenisData  = $zakatJenis->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // === Metode Pembayaran Donasi ===
        $donasiMetode = DonasiMasuk::select('jenis_donasi', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_donasi')
            ->orderByDesc('total')
            ->get();

        $donasiMetodeLabel = $donasiMetode->pluck('jenis_donasi')
            ->map(fn ($k) => ucfirst($k ?? 'Lainnya'))
            ->toArray();
        $donasiMetodeData = $donasiMetode->pluck('total')
            ->map(fn ($v) => (int) $v)
            ->toArray();

        // === Metode Pembayaran Zakat ===
        $zakatMetode = PenerimaanZakat::select('metode_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_pembayaran')
            ->orderByDesc('total')
            ->get();

        $zakatMetodeLabel = $zakatMetode->pluck('metode_pembayaran')
            ->map(fn ($k) => ucfirst($k ?? 'Lainnya'))
            ->toArray();
        $zakatMetodeData = $zakatMetode->pluck('total')
            ->map(fn ($v) => (int) $v)
            ->toArray();

        // === Kas Masuk per Sumber ===
        $kasMasukSumber = KasMasuk::select('sumber', DB::raw('SUM(jumlah) as total'))
            ->groupBy('sumber')
            ->orderByDesc('total')
            ->get();

        $kasMasukSumberLabel = $kasMasukSumber->pluck('sumber')->map(fn($k) => ucwords(str_replace('_', ' ', $k ?? 'Lainnya')))->toArray();
        $kasMasukSumberData  = $kasMasukSumber->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // === Kas Keluar per Jenis Pengeluaran ===
        $kasKeluarJenis = KasKeluar::select('jenis_pengeluaran', DB::raw('SUM(nominal) as total'))
            ->groupBy('jenis_pengeluaran')
            ->orderByDesc('total')
            ->get();

        $kasKeluarJenisLabel = $kasKeluarJenis->pluck('jenis_pengeluaran')->map(fn($k) => ucwords(str_replace('_', ' ', $k ?? 'Lainnya')))->toArray();
        $kasKeluarJenisData  = $kasKeluarJenis->pluck('total')->map(fn($v) => (float) $v)->toArray();

        // === Ringkasan ===
        $ringkasan = [
            'total_donasi'    => DonasiMasuk::sum('total'),
            'total_zakat'     => PenerimaanZakat::sum('nominal'),
            'donasi_verified' => DonasiMasuk::sum('total'),
            'zakat_verified'  => PenerimaanZakat::sum('nominal'),
            'donasi_count'    => DonasiMasuk::count(),
            'zakat_count'     => PenerimaanZakat::count(),
            'total_kas_masuk' => KasMasuk::sum('jumlah'),
            'total_kas_keluar' => KasKeluar::sum('nominal'),
            'kas_masuk_count' => KasMasuk::count(),
            'kas_keluar_count' => KasKeluar::count(),
        ];

        return view('admin.statistik.index', compact(
            'bulanList',
            'donasiPerBulan',
            'zakatPerBulan',
            'kasMasukPerBulan',
            'kasKeluarPerBulan',
            'donasiKategoriLabel',
            'donasiKategoriData',
            'zakatJenisLabel',
            'zakatJenisData',
            'donasiMetodeLabel',
            'donasiMetodeData',
            'zakatMetodeLabel',
            'zakatMetodeData',
            'kasMasukSumberLabel',
            'kasMasukSumberData',
            'kasKeluarJenisLabel',
            'kasKeluarJenisData',
            'ringkasan'
        ));
    }
}
