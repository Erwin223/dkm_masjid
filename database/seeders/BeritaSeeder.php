<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyBerita = [
            [
                'tanggal' => Carbon::today()->subDays(1)->toDateString(),
                'penulis' => 'Admin',
                'gambar' => 'berita/bJNgIm31D9QbitaRsfVXBNMq7cxGmzqvnfI1w16x.jpg',
                'judul' => 'Pembersihan Area Utama Masjid Dilakukan Serentak',
                'sinopsis' => 'Jamaah dan pengurus membersihkan area utama, tempat wudhu, serta halaman masjid menjelang akhir pekan.',
                'isi_berita' => '<p>Pengurus DKM bersama jamaah melaksanakan kegiatan gotong royong untuk menjaga kebersihan area utama masjid.</p><p>Kegiatan ini difokuskan pada ruang shalat, tempat wudhu, dan halaman depan agar jamaah merasa lebih nyaman saat beribadah.</p>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(3)->toDateString(),
                'penulis' => 'Ustaz Ahmad',
                'gambar' => 'icon/foto.jpeg',
                'judul' => 'Kajian Subuh Tentang Pentingnya Shalat Berjamaah',
                'sinopsis' => 'Kajian rutin subuh membahas pentingnya menjaga shalat berjamaah dan memakmurkan masjid.',
                'isi_berita' => '<p>Kajian subuh diisi dengan pembahasan ringan namun penuh makna tentang keutamaan shalat berjamaah.</p><ul><li>Menjaga shalat tepat waktu</li><li>Memperkuat ukhuwah jamaah</li><li>Membiasakan hadir di masjid</li></ul>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(5)->toDateString(),
                'penulis' => 'Admin',
                'gambar' => 'icon/foto2.jpeg',
                'judul' => 'Santunan Anak Yatim Berjalan Tertib dan Lancar',
                'sinopsis' => 'Penyaluran santunan dilakukan dengan suasana hangat dan tertib bersama para dermawan.',
                'isi_berita' => '<p>Program santunan anak yatim bulanan kembali dilaksanakan dengan dukungan para donatur dan jamaah masjid.</p><p>Acara berlangsung sederhana namun penuh kebersamaan, sebagai bentuk kepedulian sosial dari lingkungan masjid.</p>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(7)->toDateString(),
                'penulis' => 'Tim Dokumentasi',
                'gambar' => 'icon/foto3.jpeg',
                'judul' => 'Rapat Pengurus Bahas Program Ramadhan',
                'sinopsis' => 'Pengurus membahas persiapan kegiatan Ramadhan mulai dari jadwal, petugas, hingga logistik.',
                'isi_berita' => '<p>Rapat koordinasi dilakukan untuk memastikan seluruh agenda Ramadhan berjalan teratur dan terpantau.</p><p>Setiap bidang menyampaikan kebutuhan dan rencana kerja agar pelayanan kepada jamaah tetap optimal.</p>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(9)->toDateString(),
                'penulis' => 'Admin',
                'gambar' => 'icon/foto4.jpeg',
                'judul' => 'Pelatihan Khatib dan Imam untuk Remaja Masjid',
                'sinopsis' => 'Pembinaan remaja masjid difokuskan pada kemampuan menjadi khatib dan imam di masa mendatang.',
                'isi_berita' => '<p>Pelatihan ini bertujuan menyiapkan kader dakwah yang siap membantu kegiatan ibadah di masjid.</p><p>Peserta mendapat materi dasar adab khutbah, bacaan shalat, dan praktik tampil di depan jamaah.</p>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(11)->toDateString(),
                'penulis' => 'Humas DKM',
                'gambar' => 'icon/foto5.jpeg',
                'judul' => 'Pengecekan Sound System dan Pengeras Suara',
                'sinopsis' => 'Tim teknis melakukan pengecekan perangkat audio agar acara ibadah dan pengajian terdengar jelas.',
                'isi_berita' => '<p>Pengecekan perangkat dilakukan untuk memastikan pengeras suara berfungsi dengan baik saat shalat dan kajian.</p><p>Perawatan rutin ini penting agar kegiatan masjid berjalan lancar tanpa gangguan teknis.</p>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(13)->toDateString(),
                'penulis' => 'Admin',
                'gambar' => 'icon/foto6.jpeg',
                'judul' => 'Distribusi Infak untuk Operasional Masjid',
                'sinopsis' => 'Dana infak disalurkan untuk kebutuhan operasional dan pemeliharaan fasilitas masjid.',
                'isi_berita' => '<p>Informasi distribusi infak ditampilkan sebagai bentuk transparansi pengelolaan dana umat.</p><p>Pengurus berharap laporan seperti ini membuat jamaah lebih mudah memantau penggunaan dana masjid.</p>',
            ],
            [
                'tanggal' => Carbon::today()->subDays(15)->toDateString(),
                'penulis' => 'Tim Media',
                'gambar' => 'berita/bJNgIm31D9QbitaRsfVXBNMq7cxGmzqvnfI1w16x.jpg',
                'judul' => 'Dokumentasi Peringatan Hari Besar Islam',
                'sinopsis' => 'Rangkaian acara peringatan hari besar Islam dipublikasikan untuk memperluas informasi kepada jamaah.',
                'isi_berita' => '<p>Kegiatan peringatan hari besar Islam dihadiri oleh jamaah dari berbagai lingkungan sekitar masjid.</p><p>Dokumentasi ini membantu pengunjung melihat rangkaian acara dan partisipasi warga.</p>',
            ],
        ];

        foreach ($dummyBerita as $berita) {
            Berita::firstOrCreate(
                [
                    'judul' => $berita['judul'],
                    'tanggal' => $berita['tanggal'],
                ],
                $berita
            );
        }
    }
}
