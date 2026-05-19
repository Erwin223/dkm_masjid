<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\DonasiKeluar;
use App\Models\DonasiMasuk;
use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use App\Models\ProfilMasjid;
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
            ->limit(3)
            ->get();

        $beritaTerbaru = Berita::query()
            ->latest('tanggal')
            ->latest('id')
            ->limit(3)
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
            'navItems' => [
                ['label' => 'Beranda', 'href' => '#beranda'],
                ['label' => 'Kegiatan', 'href' => '#kegiatan'],
                ['label' => 'Berita', 'href' => '#berita'],
                ['label' => 'Laporan', 'href' => '#laporan'],
                ['label' => 'Donasi', 'href' => '#donasi'],
            ],
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
}
