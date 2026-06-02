<?php

namespace Database\Seeders;

use App\Models\JadwalKegiatan;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyJadwalKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil admin pertama sebagai approved_by
        $admin = Admin::first();
        if (!$admin) {
            // Jika tidak ada admin, skip seeder ini
            echo "Tidak ada admin yang ditemukan. Silakan buat admin terlebih dahulu.\n";
            return;
        }

        $dummyKegiatan = [
            [
                'nama_kegiatan' => 'Pengajian Rutin Subuh',
                'tanggal' => Carbon::now()->addDays(2)->toDateString(),
                'waktu' => '05:00 - 06:30',
                'tempat' => 'Aula Utama Masjid',
                'penanggung_jawab' => 'Ustaz Ahmad Hidayat',
                'keterangan' => 'Pengajian rutin setiap hari Jumat subuh dengan tema mendalam tentang akhlak islam.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Tabligh Akbar Ramadan',
                'tanggal' => Carbon::now()->addDays(7)->toDateString(),
                'waktu' => '19:00 - 21:00',
                'tempat' => 'Lapangan Masjid',
                'penanggung_jawab' => 'Pengurus DKM',
                'keterangan' => 'Acara tabligh akbar menghadirkan pembicara ternama dalam mempersiapkan umat menjelang bulan Ramadan.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Santunan Anak Yatim',
                'tanggal' => Carbon::now()->addDays(10)->toDateString(),
                'waktu' => '14:00 - 16:00',
                'tempat' => 'Aula Utama Masjid',
                'penanggung_jawab' => 'Bagian Sosial DKM',
                'keterangan' => 'Program santunan rutin untuk anak-anak yatim di sekitar masjid sebagai bentuk kepedulian sosial.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Rapat Koordinasi Pengurus DKM',
                'tanggal' => Carbon::now()->addDays(5)->toDateString(),
                'waktu' => '20:00 - 22:00',
                'tempat' => 'Ruang Rapat DKM',
                'penanggung_jawab' => 'Ketua DKM',
                'keterangan' => 'Rapat koordinasi internal pengurus DKM untuk membahas progres program dan evaluasi kegiatan bulan ini.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Kelas Mengaji Al-Quran',
                'tanggal' => Carbon::now()->addDays(3)->toDateString(),
                'waktu' => '17:00 - 18:30',
                'tempat' => 'Kelas Quran - Sayap Timur',
                'penanggung_jawab' => 'Ustazah Nur Azizah',
                'keterangan' => 'Kelas mengaji Al-Quran untuk anak-anak dan remaja dengan metode Tilawati yang interaktif.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now(),
            ],
            [
                'nama_kegiatan' => 'Pembersihan & Pemeliharaan Masjid',
                'tanggal' => Carbon::now()->addDays(8)->toDateString(),
                'waktu' => '08:00 - 11:00',
                'tempat' => 'Seluruh Area Masjid',
                'penanggung_jawab' => 'Bagian Kebersihan',
                'keterangan' => 'Gotong royong pembersihan dan perawatan sarana masjid melibatkan seluruh jamaah dan pengurus.',
                'status' => 'approved',
                'approved_by' => $admin->id,
                'approved_at' => Carbon::now(),
            ],
        ];

        foreach ($dummyKegiatan as $kegiatan) {
            JadwalKegiatan::firstOrCreate(
                ['nama_kegiatan' => $kegiatan['nama_kegiatan'], 'tanggal' => $kegiatan['tanggal']],
                $kegiatan
            );
        }

        echo "✅ Dummy data kegiatan berhasil dibuat!\n";
        echo "Total: " . count($dummyKegiatan) . " kegiatan\n";
    }
}
