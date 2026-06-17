<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Berita;
use App\Models\DistribusiZakat;
use App\Models\DonasiKeluar;
use App\Models\DonasiMasuk;
use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use App\Models\PenerimaanZakat;
use App\Models\ProfilMasjid;
use App\Models\Pengurus;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HomeController extends FrontendController
{
    public function index()
    {
        $profil = ProfilMasjid::query()->latest('id')->first();
        $today = Carbon::today();

        $nextEventObj = JadwalKegiatan::query()
            ->approved()
            ->where('tanggal', '>=', $today->toDateString())
            ->orderBy('tanggal', 'asc')
            ->first();

        $nextEvent = $nextEventObj ? [
            'title' => $nextEventObj->nama_kegiatan,
            'date' => Carbon::parse($nextEventObj->tanggal)->translatedFormat('d F Y'),
            'iso_date' => Carbon::parse($nextEventObj->tanggal)->toIso8601String(),
            'waktu' => $nextEventObj->waktu,
            'tempat' => $nextEventObj->tempat,
        ] : null;

        // Sparkline 6 months
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::today()->subMonths($i)->startOfMonth();
        }

        $chartStartDate = Carbon::today()->subMonths(5)->startOfMonth();
        $chartEndDate = Carbon::today()->endOfMonth();

        $kasMasukList = KasMasuk::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'jumlah']);

        $donasiMasukList = DonasiMasuk::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'total']);

        $zakatMasukList = PenerimaanZakat::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'nominal']);

        $kasKeluarList = KasKeluar::query()
            ->approved()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'nominal']);

        $donasiKeluarList = DonasiKeluar::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'jumlah']);

        $zakatKeluarList = DistribusiZakat::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'nominal']);

        $sparklineData = [];
        foreach ($months as $month) {
            $mStart = $month->copy()->startOfMonth();
            $mEnd = $month->copy()->endOfMonth();

            $inflow = $kasMasukList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('jumlah')
                + $donasiMasukList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('total')
                + $zakatMasukList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('nominal');

            $outflow = $kasKeluarList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('nominal')
                + $donasiKeluarList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('jumlah')
                + $zakatKeluarList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('nominal');

            $sparklineData[] = [
                'label' => $month->locale('id')->translatedFormat('M'),
                'pemasukan' => (float)$inflow,
                'pengeluaran' => (float)$outflow,
            ];
        }

        $kegiatanTerbaru = JadwalKegiatan::query()
            ->approved()
            ->orderByRaw("CASE WHEN tanggal >= ? THEN 0 ELSE 1 END", [$today->toDateString()])
            ->orderByRaw("CASE WHEN tanggal >= ? THEN tanggal END asc", [$today->toDateString()])
            ->orderByRaw("CASE WHEN tanggal < ? THEN tanggal END desc", [$today->toDateString()])
            ->limit(6)
            ->get();

        $beritaTerbaru = Berita::query()
            ->latest('tanggal')
            ->latest('id')
            ->limit(6)
            ->get();

        $kasMasukTotal = (float) KasMasuk::query()->sum('jumlah');
        $kasKeluarTotal = (float) KasKeluar::query()->approved()->sum('nominal');
        $donasiMasuk = DonasiMasuk::query()->orderBy('tanggal', 'desc')->get();
        $donasiKeluar = DonasiKeluar::query()->orderBy('tanggal', 'desc')->get();
        $donasiMasukTotal = (float) $donasiMasuk->sum(fn (DonasiMasuk $item) => (float) ($item->total ?? 0));
        $donasiKeluarTotal = (float) $donasiKeluar->sum(fn (DonasiKeluar $item) => (float) $item->nilai_dana);

        $profilCards = [
            [
                'title' => 'Visi',
                'content' => $profil?->visi
                    ? Str::limit(strip_tags($profil->visi), 110)
                    : 'Data visi masjid belum diisi di modul profil masjid.',
            ],
            [
                'title' => 'Misi',
                'content' => $profil?->misi
                    ? Str::limit(strip_tags($profil->misi), 110)
                    : 'Data misi masjid belum diisi di modul profil masjid.',
            ],
        ];

        $kegiatanCards = $kegiatanTerbaru->map(function (JadwalKegiatan $item) use ($today) {
            $tanggal = Carbon::parse($item->tanggal);
            $status = $tanggal->isSameDay($today)
                ? 'Hari ini'
                : ($tanggal->isFuture() ? 'Akan datang' : 'Selesai');

            return [
                'title' => $item->nama_kegiatan,
                'value' => $tanggal->translatedFormat('d M Y'),
                'content' => trim(collect([
                    $item->waktu,
                    $item->tempat,
                    $status,
                ])->filter()->implode(' | ')),
            ];
        })->all();

        $laporanCards = [
            [
                'title' => 'Kas Masuk',
                'value' => $this->formatCurrencyShort($kasMasukTotal),
                'content' => 'Total akumulasi penerimaan kas masjid.',
            ],
            [
                'title' => 'Kas Keluar',
                'value' => $this->formatCurrencyShort($kasKeluarTotal),
                'content' => 'Total akumulasi pengeluaran kas masjid.',
            ],
            [
                'title' => 'Saldo Kas',
                'value' => $this->formatCurrencyShort($kasMasukTotal - $kasKeluarTotal),
                'content' => 'Selisih antara kas masuk dan kas keluar.',
            ],
        ];

        $donasiCards = [
            [
                'title' => 'Donasi Masuk',
                'value' => $this->formatCurrencyShort($donasiMasukTotal),
                'content' => 'Akumulasi seluruh donasi yang diterima.',
            ],
            [
                'title' => 'Donasi Keluar',
                'value' => $this->formatCurrencyShort($donasiKeluarTotal),
                'content' => 'Akumulasi penyaluran donasi yang sudah dicatat.',
            ],
            [
                'title' => 'Saldo Donasi',
                'value' => $this->formatCurrencyShort($donasiMasukTotal - $donasiKeluarTotal),
                'content' => 'Selisih donasi masuk dan donasi yang telah disalurkan.',
            ],
        ];

        $overviewStats = [
            [
                'label' => 'Agenda Tersedia',
                'value' => (string) JadwalKegiatan::query()->approved()->count(),
            ],
            [
                'label' => 'Berita Terpublikasi',
                'value' => (string) Berita::query()->count(),
            ],
            [
                'label' => 'Saldo Donasi',
                'value' => $this->formatCurrencyShort($donasiMasukTotal - $donasiKeluarTotal),
            ],
        ];

        // Fetch Jadwal Imam
        $jadwalImamObj = \App\Models\JadwalImam::with('imam')
            ->where('tanggal', '>=', $today->toDateString())
            ->orderBy('tanggal', 'asc')
            ->orderByRaw("CASE waktu_sholat 
                WHEN 'Subuh' THEN 1 
                WHEN 'Dzuhur' THEN 2 
                WHEN 'Ashar' THEN 3 
                WHEN 'Maghrib' THEN 4 
                WHEN 'Isya' THEN 5 
                ELSE 6 END")
            ->limit(15)
            ->get();

        $jadwalImam = $jadwalImamObj->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d M Y');
        });

        return view('frontend.home', [
            'heroImage' => asset('storage/icon/foto.jpeg'),
            'quickLinks' => $this->homeQuickLinks(),
            'defaultCity' => [
                'id' => '1215',
                'name' => 'Kab. Subang',
            ],
            'cityOptions' => [
                ['id' => '1201', 'name' => 'Kab. Bandung'],
                ['id' => '1202', 'name' => 'Kab. Bandung Barat'],
                ['id' => '1203', 'name' => 'Kab. Bekasi'],
                ['id' => '1204', 'name' => 'Kab. Bogor'],
                ['id' => '1205', 'name' => 'Kab. Ciamis'],
                ['id' => '1206', 'name' => 'Kab. Cianjur'],
                ['id' => '1207', 'name' => 'Kab. Cirebon'],
                ['id' => '1208', 'name' => 'Kab. Garut'],
                ['id' => '1209', 'name' => 'Kab. Indramayu'],
                ['id' => '1210', 'name' => 'Kab. Karawang'],
                ['id' => '1211', 'name' => 'Kab. Kuningan'],
                ['id' => '1212', 'name' => 'Kab. Majalengka'],
                ['id' => '1213', 'name' => 'Kab. Pangandaran'],
                ['id' => '1214', 'name' => 'Kab. Purwakarta'],
                ['id' => '1215', 'name' => 'Kab. Subang'],
                ['id' => '1216', 'name' => 'Kab. Sukabumi'],
                ['id' => '1217', 'name' => 'Kab. Sumedang'],
                ['id' => '1218', 'name' => 'Kab. Tasikmalaya'],
                ['id' => '1219', 'name' => 'Kota Bandung'],
                ['id' => '1220', 'name' => 'Kota Banjar'],
                ['id' => '1221', 'name' => 'Kota Bekasi'],
                ['id' => '1222', 'name' => 'Kota Bogor'],
                ['id' => '1223', 'name' => 'Kota Cimahi'],
                ['id' => '1224', 'name' => 'Kota Cirebon'],
                ['id' => '1225', 'name' => 'Kota Depok'],
                ['id' => '1226', 'name' => 'Kota Sukabumi'],
                ['id' => '1227', 'name' => 'Kota Tasikmalaya'],
            ],
            'navItems' => $this->frontendNavItems(),
            'quotes' => [
                [
                    'title' => 'Mutiara Nasihat',
                    'text' => 'Tidaklah kedua kaki seorang hamba berdiri di jalan Allah, melainkan ia tidak akan disentuh api neraka.',
                    'source' => 'HR. Bukhari',
                    'date' => '(1447-09-14 / 2026-03-04)',
                ],
                [
                    'title' => 'Pengingat Hari Ini',
                    'text' => 'Shalat berjamaah lebih utama daripada shalat sendirian dengan dua puluh tujuh derajat.',
                    'source' => 'HR. Bukhari dan Muslim',
                    'date' => '(1447-11-08 / 2026-05-25)',
                ],
                [
                    'title' => 'Seruan Kebaikan',
                    'text' => 'Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia lainnya.',
                    'source' => 'HR. Ahmad',
                    'date' => '(1447-12-17 / 2026-07-03)',
                ],
            ],
            'profil' => $profil,
            'profilCards' => $profilCards,
            'kegiatanCards' => $kegiatanCards,
            'beritaTerbaru' => $beritaTerbaru,
            'laporanCards' => $laporanCards,
            'donasiCards' => $donasiCards,
            'overviewStats' => $overviewStats,
            'nextEvent' => $nextEvent,
            'sparkline_data' => $sparklineData,
            'jadwalImam' => $jadwalImam,
        ]);
    }

    private function formatCurrencyShort(float $amount): string
    {
        if (abs($amount) >= 1000000000) {
            return 'Rp ' . number_format($amount / 1000000000, 1, ',', '.') . ' M';
        }

        if (abs($amount) >= 1000000) {
            return 'Rp ' . number_format($amount / 1000000, 1, ',', '.') . ' Jt';
        }

        if (abs($amount) >= 1000) {
            return 'Rp ' . number_format($amount / 1000, 1, ',', '.') . ' Rb';
        }

        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public function profil()
    {
        $profil = ProfilMasjid::query()->latest('id')->first();

        $order = ['Ketua DKM', 'Ketua', 'Sekretaris', 'Sekertaris', 'Bendahara'];

        $pengurus = Pengurus::query()
            ->orderBy('id')
            ->get()
            ->filter(function ($p) {
                $jabatan = strtolower(trim($p->jabatan));
                return str_contains($jabatan, 'ketua') ||
                       str_contains($jabatan, 'sekretaris') ||
                       str_contains($jabatan, 'sekertaris') ||
                       str_contains($jabatan, 'bendahara');
            })
            ->sortBy(function ($p) use ($order) {
                foreach ($order as $index => $role) {
                    if (str_contains(strtolower($p->jabatan), strtolower($role))) {
                        return $index;
                    }
                }
                return 99;
            })
            ->values()
            ->map(function ($p) {
                return [
                    'jabatan' => $p->jabatan,
                    'nama' => $p->nama,
                    'foto' => $p->foto ? asset('storage/' . ltrim($p->foto, '/')) : null,
                    'no_hp' => $p->no_hp ?? null,
                    'tugas' => $p->tugas ?? null,
                ];
            })
            ->all();

        return view('frontend.profil.index', [
            'profil' => $profil,
            'pengurus' => $pengurus,
            'navItems' => $this->frontendNavItems(),
        ]);
    }

    public function pengurusLengkap()
    {
        $allPengurus = Pengurus::query()->orderBy('id')->get();

        $order = ['Ketua DKM', 'Ketua', 'Sekretaris', 'Sekertaris', 'Bendahara'];

        $pengurusInti = $allPengurus->filter(function ($p) {
            $jabatan = strtolower(trim($p->jabatan));
            return str_contains($jabatan, 'ketua') ||
                   str_contains($jabatan, 'sekretaris') ||
                   str_contains($jabatan, 'sekertaris') ||
                   str_contains($jabatan, 'bendahara');
        })->sortBy(function ($p) use ($order) {
            foreach ($order as $index => $role) {
                if (str_contains(strtolower($p->jabatan), strtolower($role))) {
                    return $index;
                }
            }
            return 99;
        })->values();

        $anggotaDivisi = $allPengurus->reject(function ($p) use ($pengurusInti) {
            return $pengurusInti->contains('id', $p->id);
        });

        $anggotaAgregasi = $anggotaDivisi->groupBy('jabatan')->map(function ($items, $key) {
            return [
                'jabatan' => $key,
                'total' => $items->count(),
            ];
        })->values();

        return view('frontend.profil.pengurus', [
            'navItems' => $this->frontendNavItems(),
            'pengurusInti' => $pengurusInti,
            'anggotaAgregasi' => $anggotaAgregasi,
        ]);
    }

    public function berita()
    {
        $beritaPaginated = Berita::query()
            ->latest('tanggal')
            ->latest('id')
            ->paginate(6);

        $berita = $beritaPaginated->map(fn (Berita $item) => [
            'id' => $item->id,
            'tanggal' => $item->tanggal,
            'judul' => $item->judul,
            'excerpt' => $item->sinopsis ?: Str::limit(strip_tags((string) $item->isi_berita), 140),
            'thumbnail' => $item->gambar ? asset('storage/' . ltrim($item->gambar, '/')) : asset('favicon.ico'),
            'slug' => Str::slug($item->judul),
            'url' => route('frontend.berita.show', $item->id),
        ]);

        return view('frontend.berita.index', [
            'berita' => $berita,
            'beritaPaginated' => $beritaPaginated,
            'navItems' => $this->frontendNavItems(),
        ]);
    }

    /**
     * Tampilkan halaman detail berita
     *
     * @param \App\Models\Berita $berita
     * @return \Illuminate\View\View
     */
    public function showBerita(Berita $berita)
    {
        // Ambil 3 berita terbaru lainnya (exclude berita yang sedang dibaca)
        $berita_lain = Berita::query()
            ->where('id', '!=', $berita->id)
            ->latest('tanggal')
            ->latest('id')
            ->limit(3)
            ->get();

        return view('frontend.berita.show', [
            'berita' => $berita,
            'berita_lain' => $berita_lain,
        ]);
    }

    public function galeri()
    {
        $galeriPaginated = \App\Models\Galeri::query()
            ->latest('tanggal')
            ->latest('id')
            ->paginate(6);

        $galeri = $galeriPaginated->map(fn (\App\Models\Galeri $item) => [
            'tanggal' => $item->tanggal,
            'judul' => $item->judul,
            'deskripsi' => $item->deskripsi,
            'thumbnail' => $item->gambar ? asset('storage/' . ltrim($item->gambar, '/')) : asset('favicon.ico'),
        ]);

        return view('frontend.galeri.index', [
            'galeri' => $galeri,
            'galeriPaginated' => $galeriPaginated,
            'navItems' => $this->frontendNavItems(),
        ]);
    }

    public function donasi()
    {
        return view('frontend.donasi.index', [
            'navItems' => $this->frontendNavItems(),
        ]);
    }

    public function laporan()
    {
        [$preset, $dateFrom, $dateTo, $periodLabel] = $this->resolveFrontendReportPeriod();

        $kasMasukTotal = (float) KasMasuk::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->sum('jumlah');

        $kasKeluarTotal = (float) KasKeluar::query()
            ->approved()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->sum('nominal');

        $donasiMasukTotal = (float) DonasiMasuk::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->sum('total');

        $donasiKeluarTotal = (float) DonasiKeluar::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->sum('jumlah');

        $zakatMasukTotal = (float) PenerimaanZakat::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->sum('nominal');

        $zakatKeluarTotal = (float) DistribusiZakat::query()
            ->whereBetween('tanggal', [$dateFrom->toDateString(), $dateTo->toDateString()])
            ->sum('nominal');

        $daftarLaporan = Arsip::query()
            ->where('kategori', 'Laporan')
            ->orderByDesc('tanggal_arsip')
            ->orderByDesc('id')
            ->get()
            ->map(function (Arsip $item) {
                return (object) [
                    'periode' => $item->judul,
                    'keterangan' => $item->deskripsi,
                    'file_path' => $item->file,
                    'nama_file_asli' => $item->nama_file_asli,
                    'tanggal_arsip' => $item->tanggal_arsip,
                ];
            });

        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[] = $dateTo->copy()->subMonths($i)->startOfMonth();
        }

        $chartStartDate = $dateTo->copy()->subMonths(11)->startOfMonth();
        $chartEndDate = $dateTo->copy()->endOfMonth();

        $kasMasukList = KasMasuk::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'jumlah']);

        $donasiMasukList = DonasiMasuk::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'total']);

        $zakatMasukList = PenerimaanZakat::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'nominal']);

        $kasKeluarList = KasKeluar::query()
            ->approved()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'nominal']);

        $donasiKeluarList = DonasiKeluar::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'jumlah']);

        $zakatKeluarList = DistribusiZakat::query()
            ->whereBetween('tanggal', [$chartStartDate->toDateString(), $chartEndDate->toDateString()])
            ->get(['tanggal', 'nominal']);

        $chartData = [];
        foreach ($months as $month) {
            $mStart = $month->copy()->startOfMonth();
            $mEnd = $month->copy()->endOfMonth();

            $inflow = $kasMasukList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('jumlah')
                + $donasiMasukList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('total')
                + $zakatMasukList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('nominal');

            $outflow = $kasKeluarList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('nominal')
                + $donasiKeluarList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('jumlah')
                + $zakatKeluarList->filter(fn($item) => Carbon::parse($item->tanggal)->between($mStart, $mEnd))->sum('nominal');

            $chartData[] = [
                'label' => $month->locale('id')->translatedFormat('M'),
                'label_full' => $month->locale('id')->translatedFormat('F Y'),
                'pemasukan' => (float)$inflow,
                'pengeluaran' => (float)$outflow,
            ];
        }

        return view('frontend.laporan.index', [
            'navItems' => $this->frontendNavItems(),
            'daftar_laporan' => $daftarLaporan,
            'total_pemasukan' => $kasMasukTotal + $donasiMasukTotal + $zakatMasukTotal,
            'total_pengeluaran' => $kasKeluarTotal + $donasiKeluarTotal + $zakatKeluarTotal,
            'saldo_akhir' => ($kasMasukTotal + $donasiMasukTotal + $zakatMasukTotal) - ($kasKeluarTotal + $donasiKeluarTotal + $zakatKeluarTotal),
            'periode_label' => $periodLabel,
            'filter_preset' => $preset,
            'filter_date_from' => $dateFrom->format('Y-m-d'),
            'filter_date_to' => $dateTo->format('Y-m-d'),
            'chart_data' => $chartData,
        ]);
    }

    private function resolveFrontendReportPeriod(): array
    {
        $preset = request()->string('preset')->toString() ?: 'this_month';
        $today = Carbon::today();

        if ($preset === 'custom' || request()->filled('date_from') || request()->filled('date_to')) {
            $preset = 'custom';
            $dateFrom = request()->filled('date_from')
                ? Carbon::parse(request()->input('date_from'))->startOfDay()
                : $today->copy()->startOfMonth();
            $dateTo = request()->filled('date_to')
                ? Carbon::parse(request()->input('date_to'))->endOfDay()
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

}
