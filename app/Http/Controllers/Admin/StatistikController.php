<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiMasuk;
use App\Models\PenerimaanZakat;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        // === Tren Donasi & Zakat per Bulan (6 bulan terakhir) ===
        $bulanList = [];
        $donasiPerBulan = [];
        $zakatPerBulan = [];

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

        // === Ringkasan ===
        $ringkasan = [
            'total_donasi'    => DonasiMasuk::sum('total'),
            'total_zakat'     => PenerimaanZakat::sum('nominal'),
            'donasi_verified' => DonasiMasuk::sum('total'),
            'zakat_verified'  => PenerimaanZakat::sum('nominal'),
            'donasi_count'    => DonasiMasuk::count(),
            'zakat_count'     => PenerimaanZakat::count(),
        ];

        return view('admin.statistik.index', compact(
            'bulanList',
            'donasiPerBulan',
            'zakatPerBulan',
            'donasiKategoriLabel',
            'donasiKategoriData',
            'zakatJenisLabel',
            'zakatJenisData',
            'donasiMetodeLabel',
            'donasiMetodeData',
            'zakatMetodeLabel',
            'zakatMetodeData',
            'ringkasan'
        ));
    }
}
