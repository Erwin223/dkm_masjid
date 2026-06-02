<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GaleriSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyGaleri = [
            [
                'tanggal' => Carbon::today()->subDays(1)->toDateString(),
                'gambar' => 'galeri/KMOxmUmdcu62eNjYtKeUrgkQO74ReY7XR5Aky71A.png',
                'judul' => 'Gotong Royong Membersihkan Area Masjid',
                'deskripsi' => 'Jamaah bersama pengurus membersihkan ruang utama, tempat wudhu, dan halaman masjid.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(3)->toDateString(),
                'gambar' => 'icon/foto.jpeg',
                'judul' => 'Kajian Subuh Bersama Ustaz Tamu',
                'deskripsi' => 'Dokumentasi kajian subuh yang dihadiri jamaah bapak-bapak dengan suasana khusyuk.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(5)->toDateString(),
                'gambar' => 'icon/foto2.jpeg',
                'judul' => 'Santunan Anak Yatim Bulanan',
                'deskripsi' => 'Penyaluran santunan dilakukan secara tertib dan penuh kebersamaan.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(7)->toDateString(),
                'gambar' => 'icon/foto3.jpeg',
                'judul' => 'Rapat Pengurus DKM Bulanan',
                'deskripsi' => 'Forum evaluasi program masjid agar pelayanan kepada jamaah semakin baik.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(9)->toDateString(),
                'gambar' => 'icon/foto4.jpeg',
                'judul' => 'Pelatihan Khatib dan Imam',
                'deskripsi' => 'Kegiatan pembinaan untuk meningkatkan kualitas dakwah dan ibadah berjamaah.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(11)->toDateString(),
                'gambar' => 'icon/foto5.jpeg',
                'judul' => 'Persiapan Ramadhan Bersama Remaja Masjid',
                'deskripsi' => 'Relawan menata perlengkapan dan area masjid menjelang bulan suci Ramadhan.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(13)->toDateString(),
                'gambar' => 'icon/foto6.jpeg',
                'judul' => 'Pengecekan Sound System Masjid',
                'deskripsi' => 'Tim teknis memastikan pengeras suara siap digunakan untuk shalat dan pengajian.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(15)->toDateString(),
                'gambar' => 'berita/bJNgIm31D9QbitaRsfVXBNMq7cxGmzqvnfI1w16x.jpg',
                'judul' => 'Dokumentasi Hari Besar Islam',
                'deskripsi' => 'Rangkaian acara peringatan hari besar Islam terekam dalam dokumentasi kegiatan masjid.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(17)->toDateString(),
                'gambar' => 'galeri/KMOxmUmdcu62eNjYtKeUrgkQO74ReY7XR5Aky71A.png',
                'judul' => 'Pengajian Malam Jumat',
                'deskripsi' => 'Jamaah mengikuti pengajian rutin malam Jumat dengan suasana yang tertib dan nyaman.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(19)->toDateString(),
                'gambar' => 'icon/foto.jpeg',
                'judul' => 'Layanan Kebersihan Masjid',
                'deskripsi' => 'Pengurus menjaga kebersihan fasilitas masjid agar selalu layak digunakan jamaah.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(21)->toDateString(),
                'gambar' => 'icon/foto2.jpeg',
                'judul' => 'Kegiatan Sosial untuk Warga Sekitar',
                'deskripsi' => 'Bantuan sosial diberikan kepada warga sekitar masjid yang membutuhkan dukungan.',
            ],
            [
                'tanggal' => Carbon::today()->subDays(23)->toDateString(),
                'gambar' => 'icon/foto3.jpeg',
                'judul' => 'Persiapan Acara Jumat Berkah',
                'deskripsi' => 'Tim panitia menyiapkan konsumsi dan perlengkapan acara Jumat Berkah untuk jamaah.',
            ],
        ];

        foreach ($dummyGaleri as $galeri) {
            Galeri::firstOrCreate(
                [
                    'judul' => $galeri['judul'],
                    'tanggal' => $galeri['tanggal'],
                ],
                $galeri
            );
        }
    }
}
