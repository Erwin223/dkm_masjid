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

class HomeController extends Controller
{
    public function index()
    {
        $profil = ProfilMasjid::query()->latest('id')->first();
        $today = Carbon::today();

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

        return view('frontend.home', [
            'heroImage' => asset('storage/icon/foto.jpeg'),
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

        $order = ['Ketua DKM', 'Sekretaris', 'Bendahara', 'Bidang Ibadah'];

        $pengurus = Pengurus::query()
            ->orderBy('id')
            ->get()
            ->sortBy(function ($p) use ($order) {
                $i = array_search($p->jabatan, $order);
                return $i === false ? 999 : $i;
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

        return view('frontend.profil', [
            'profil' => $profil,
            'pengurus' => $pengurus,
            'navItems' => $this->frontendNavItems(),
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

        return view('frontend.berita', [
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

        return view('frontend.galeri', [
            'galeri' => $galeri,
            'galeriPaginated' => $galeriPaginated,
            'navItems' => $this->frontendNavItems(),
        ]);
    }

    public function donasi()
    {
        return view('frontend.donasi', [
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
                ];
            });

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

    private function frontendNavItems(): array
    {
        return [
            [
                'label' => 'Beranda',
                'href' => route('frontend.home'),
                'active' => request()->routeIs('frontend.home'),
                'icon' => 'bi-house-door',
            ],
            [
                'label' => 'Profil Masjid',
                'href' => route('frontend.profil'),
                'active' => request()->routeIs('frontend.profil'),
                'icon' => 'bi-building',
            ],
            [
                'label' => 'Berita',
                'href' => route('frontend.berita'),
                'active' => request()->routeIs('frontend.berita'),
                'icon' => 'bi-newspaper',
            ],
            [
                'label' => 'Kegiatan & Galeri',
                'href' => '#',
                'active' => request()->routeIs('frontend.kegiatan') || request()->routeIs('frontend.galeri'),
                'icon' => 'bi-collection',
                'dropdown' => [
                    [
                        'label' => 'Jadwal Kegiatan',
                        'href' => route('frontend.kegiatan'),
                        'active' => request()->routeIs('frontend.kegiatan'),
                        'icon' => 'bi-calendar-event',
                    ],
                    [
                        'label' => 'Galeri Foto',
                        'href' => route('frontend.galeri'),
                        'active' => request()->routeIs('frontend.galeri'),
                        'icon' => 'bi-images',
                    ],
                ]
            ],
            [
                'label' => 'Laporan',
                'href' => route('frontend.laporan'),
                'active' => request()->routeIs('frontend.laporan'),
                'icon' => 'bi-file-earmark-text',
            ],
            [
                'label' => 'Donasi',
                'href' => route('frontend.donasi'),
                'active' => request()->routeIs('frontend.donasi'),
                'icon' => 'bi-heart-fill',
            ],
        ];
    }
}
