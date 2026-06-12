<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use Carbon\Carbon;

class KegiatanController extends FrontendController
{
    /**
     * Menampilkan halaman jadwal kegiatan frontend
     */
    public function index()
    {
        $today = Carbon::today();

        // Ambil kegiatan terdekat berikutnya (upcoming) untuk highlight banner
        $nextKegiatan = JadwalKegiatan::query()
            ->where('status', 'approved')
            ->where('tanggal', '>=', $today->toDateString())
            ->orderBy('tanggal', 'asc')
            ->first();

        // Ambil daftar kegiatan yang sudah disetujui, diurutkan Descending (terbaru di atas)
        // Dibatasi maksimal 5 data per halaman (Pagination)
        $paginator = JadwalKegiatan::query()
            ->where('status', 'approved')
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        // Tambahkan konversi tanggal Hijriah ke setiap item kegiatan
        $paginator->getCollection()->transform(function ($kegiatan) {
            $kegiatan->tanggal_hijri = $this->toHijriString($kegiatan->tanggal);
            return $kegiatan;
        });

        return view('frontend.kegiatan.index', [
            'jadwal_kegiatan' => $paginator,
            'nextKegiatan'    => $nextKegiatan,
            'navItems'        => $this->frontendNavItems(),
        ]);
    }

    /**
     * Konversi tanggal Masehi ke Hijriah secara akurat
     */
    private function toHijriString($dateString)
    {
        $carbon = Carbon::parse($dateString);
        $y = $carbon->year;
        $m = $carbon->month;
        $d = $carbon->day;

        if ($m < 3) {
            $y -= 1;
            $m += 12;
        }

        $a = floor($y / 100);
        $b = 2 - $a + floor($a / 4);
        $jd = floor(365.25 * ($y + 4716)) + floor(30.6001 * ($m + 1)) + $d + $b - 1524.5;

        $i = $jd - 1948084;
        $cy = floor(($i - 0.5) / 10631);
        $i = $i - 10631 * $cy;
        $l = floor(($i - 0.5) / 354);
        $i = $i - 354 * $l;

        $j = floor(($i - 0.5) / 29.5);
        $hd = $i - floor($j * 29.5);
        $hm = $j + 1;
        $hy = 30 * $cy + $l;

        $hijriMonths = [
            1 => "Muharram", 2 => "Safar", 3 => "Rabi'ul Awal", 4 => "Rabi'ul Akhir",
            5 => "Jumadil Awal", 6 => "Jumadil Akhir", 7 => "Rajab", 8 => "Sya'ban",
            9 => "Ramadhan", 10 => "Syawal", 11 => "Dzulqa'dah", 12 => "Dzulhijjah"
        ];

        $monthName = $hijriMonths[(int)$hm] ?? 'Ramadhan';
        return (int)$hd . ' ' . $monthName . ' ' . (int)$hy . ' H';
    }
}
