<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistribusiZakat;
use App\Models\DonasiKeluar;
use App\Models\DonasiMasuk;
use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use App\Models\PenerimaanZakat;
use App\Models\ProfilMasjid;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        return $this->renderReport($request, 'ringkasan');
    }

    public function kas(Request $request)
    {
        return $this->renderReport($request, 'kas');
    }

    public function donasi(Request $request)
    {
        return $this->renderReport($request, 'donasi');
    }

    public function zakat(Request $request)
    {
        return $this->renderReport($request, 'zakat');
    }

    public function kegiatan(Request $request)
    {
        return $this->renderReport($request, 'kegiatan');
    }

    private function renderReport(Request $request, string $defaultReportType)
    {
        [$preset, $dateFrom, $dateTo, $periodLabel] = $this->resolvePeriod($request);
        $reportType = $defaultReportType;
        $profilMasjid = ProfilMasjid::query()->latest('id')->first();
        $namaMasjid = $profilMasjid->nama ?? 'Masjid Al-Musabaqoh Subang';

        $kasMasuk = KasMasuk::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $kasKeluar = KasKeluar::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $donasiMasuk = DonasiMasuk::with('donatur')
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $donasiKeluar = DonasiKeluar::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $penerimaanZakat = PenerimaanZakat::with('muzakki')
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $distribusiZakat = DistribusiZakat::with('mustahik')
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'desc')
            ->get();

        $kegiatan = JadwalKegiatan::with('kasKeluar')
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->orderBy('tanggal', 'asc')
            ->get();

        $kasSummary = [
            'masuk_total' => (float) $kasMasuk->sum('jumlah'),
            'keluar_total' => (float) $kasKeluar->sum('nominal'),
            'masuk_count' => $kasMasuk->count(),
            'keluar_count' => $kasKeluar->count(),
        ];
        $kasSummary['saldo'] = $kasSummary['masuk_total'] - $kasSummary['keluar_total'];

        $donasiSummary = [
            'masuk_total' => $this->sumDonasiMasuk($donasiMasuk),
            'keluar_total' => $this->sumDonasiKeluar($donasiKeluar),
            'masuk_count' => $donasiMasuk->count(),
            'keluar_count' => $donasiKeluar->count(),
        ];
        $donasiSummary['saldo'] = $donasiSummary['masuk_total'] - $donasiSummary['keluar_total'];

        $zakatSummary = [
            'masuk_total' => $this->sumPenerimaanZakat($penerimaanZakat),
            'keluar_total' => $this->sumDistribusiZakat($distribusiZakat),
            'masuk_count' => $penerimaanZakat->count(),
            'keluar_count' => $distribusiZakat->count(),
        ];
        $zakatSummary['saldo'] = $zakatSummary['masuk_total'] - $zakatSummary['keluar_total'];

        $today = Carbon::today();
        $kegiatanSummary = [
            'count' => $kegiatan->count(),
            'estimasi_total' => $kegiatan->sum(fn (JadwalKegiatan $item): float => (float) ($item->estimasi_anggaran ?? 0)),
            'realisasi_total' => $kegiatan->sum(fn (JadwalKegiatan $item): float => (float) optional($item->kasKeluar)->nominal),
            'today_count' => $kegiatan->filter(fn (JadwalKegiatan $item): bool => Carbon::parse($item->tanggal)->isSameDay($today))->count(),
            'upcoming_count' => $kegiatan->filter(fn (JadwalKegiatan $item): bool => Carbon::parse($item->tanggal)->isFuture())->count(),
            'completed_count' => $kegiatan->filter(fn (JadwalKegiatan $item): bool => Carbon::parse($item->tanggal)->isPast() && ! Carbon::parse($item->tanggal)->isSameDay($today))->count(),
        ];

        $overallSummary = [
            'masuk_total' => $kasSummary['masuk_total'] + $donasiSummary['masuk_total'] + $zakatSummary['masuk_total'],
            'keluar_total' => $kasSummary['keluar_total'] + $donasiSummary['keluar_total'] + $zakatSummary['keluar_total'],
            'transaksi_total' => $kasSummary['masuk_count'] + $kasSummary['keluar_count']
                + $donasiSummary['masuk_count'] + $donasiSummary['keluar_count']
                + $zakatSummary['masuk_count'] + $zakatSummary['keluar_count'],
        ];
        $overallSummary['saldo'] = $overallSummary['masuk_total'] - $overallSummary['keluar_total'];

        $reportConfig = [
            'ringkasan' => [
                'title' => 'Ringkasan Semua Laporan',
                'document_title' => 'Ringkasan Laporan ' . $namaMasjid . ' Periode ' . $periodLabel,
                'print_orientation' => 'portrait',
                'transaksi_total' => $overallSummary['transaksi_total'],
            ],
            'kas' => [
                'title' => 'Laporan Kas',
                'document_title' => 'Laporan Kas ' . $namaMasjid . ' Periode ' . $periodLabel,
                'print_orientation' => 'portrait',
                'transaksi_total' => $kasSummary['masuk_count'] + $kasSummary['keluar_count'],
            ],
            'donasi' => [
                'title' => 'Laporan Donasi',
                'document_title' => 'Laporan Donasi ' . $namaMasjid . ' Periode ' . $periodLabel,
                'print_orientation' => 'portrait',
                'transaksi_total' => $donasiSummary['masuk_count'] + $donasiSummary['keluar_count'],
            ],
            'zakat' => [
                'title' => 'Laporan Zakat',
                'document_title' => 'Laporan Zakat ' . $namaMasjid . ' Periode ' . $periodLabel,
                'print_orientation' => 'portrait',
                'transaksi_total' => $zakatSummary['masuk_count'] + $zakatSummary['keluar_count'],
            ],
            'kegiatan' => [
                'title' => 'Laporan Kegiatan',
                'document_title' => 'Laporan Kegiatan ' . $namaMasjid . ' Periode ' . $periodLabel,
                'print_orientation' => 'landscape',
                'transaksi_total' => $kegiatanSummary['count'],
            ],
        ];

        $activeReport = $reportConfig[$reportType];

        return view('admin.laporan.index', [
            'preset' => $preset,
            'reportType' => $reportType,
            'activeReport' => $activeReport,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'periodLabel' => $periodLabel,
            'namaMasjid' => $namaMasjid,
            'reportDocumentTitle' => $activeReport['document_title'],
            'reportSummaryDocumentTitle' => 'Ringkasan Laporan ' . $namaMasjid . ' Periode ' . $periodLabel,
            'reportKegiatanDocumentTitle' => 'Laporan Kegiatan ' . $namaMasjid . ' Periode ' . $periodLabel,
            'generatedAt' => now(),
            'overallSummary' => $overallSummary,
            'kasSummary' => $kasSummary,
            'donasiSummary' => $donasiSummary,
            'zakatSummary' => $zakatSummary,
            'kegiatanSummary' => $kegiatanSummary,
            'kasMasuk' => $kasMasuk,
            'kasKeluar' => $kasKeluar,
            'donasiMasuk' => $donasiMasuk,
            'donasiKeluar' => $donasiKeluar,
            'penerimaanZakat' => $penerimaanZakat,
            'distribusiZakat' => $distribusiZakat,
            'kegiatan' => $kegiatan,
        ]);
    }

    private function resolvePeriod(Request $request): array
    {
        $preset = $request->string('preset')->toString() ?: 'this_month';
        $today = Carbon::today();

        if ($preset === 'custom' || $request->filled('date_from') || $request->filled('date_to')) {
            $preset = 'custom';
            $dateFrom = $request->filled('date_from')
                ? Carbon::parse($request->input('date_from'))->startOfDay()
                : $today->copy()->startOfMonth();
            $dateTo = $request->filled('date_to')
                ? Carbon::parse($request->input('date_to'))->endOfDay()
                : $today->copy()->endOfMonth();
        } else {
            switch ($preset) {
                case 'today':
                    $dateFrom = $today->copy()->startOfDay();
                    $dateTo = $today->copy()->endOfDay();
                    break;
                case 'this_year':
                    $dateFrom = $today->copy()->startOfYear();
                    $dateTo = $today->copy()->endOfYear();
                    break;
                case 'last_30_days':
                    $dateFrom = $today->copy()->subDays(29)->startOfDay();
                    $dateTo = $today->copy()->endOfDay();
                    break;
                case 'this_month':
                default:
                    $preset = 'this_month';
                    $dateFrom = $today->copy()->startOfMonth();
                    $dateTo = $today->copy()->endOfMonth();
                    break;
            }
        }

        if ($dateFrom->gt($dateTo)) {
            [$dateFrom, $dateTo] = [$dateTo->copy()->startOfDay(), $dateFrom->copy()->endOfDay()];
        }

        $periodLabel = $dateFrom->isSameDay($dateTo)
            ? $dateFrom->translatedFormat('d M Y')
            : $dateFrom->translatedFormat('d M Y') . ' - ' . $dateTo->translatedFormat('d M Y');

        return [$preset, $dateFrom, $dateTo, $periodLabel];
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
}
