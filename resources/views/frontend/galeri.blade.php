<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Kegiatan - DKM Al-Musabaqoh</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('frontend._styles')
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="frontend-shell">
    @php
        $navItems = [
            ['label' => 'Beranda', 'href' => route('frontend.home'), 'active' => request()->routeIs('frontend.home')],
            ['label' => 'Profil Masjid', 'href' => route('frontend.profil'), 'active' => request()->routeIs('frontend.profil')],
            ['label' => 'Berita', 'href' => route('frontend.berita'), 'active' => request()->routeIs('frontend.berita')],
            ['label' => 'Galeri', 'href' => route('frontend.galeri'), 'active' => request()->routeIs('frontend.galeri')],
        ];

        // Prefer data passed from controller: $galeri (collection of Galeri models)
        $galeriItems = collect($galeri ?? [])->whenEmpty(function () {
            return collect([
                [
                    'tanggal' => '2026-05-14',
                    'judul' => 'Pembersihan Area Utama Masjid',
                    'deskripsi' => 'Gotong royong jamaah membersihkan ruang utama sebelum shalat Jumat.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1507863295159-0c5f9b5d4f2b?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'tanggal' => '2026-05-10',
                    'judul' => 'Kajian Subuh Bersama Ustadz Tamu',
                    'deskripsi' => 'Dokumentasi kegiatan kajian subuh yang dihadiri para bapak dan jamaah sekitar.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1519764622345-23439dd774f7?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'tanggal' => '2026-05-05',
                    'judul' => 'Santunan Anak Yatim Bulanan',
                    'deskripsi' => 'Penyaluran santunan dilakukan dengan tertib dan penuh kebersamaan.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'tanggal' => '2026-04-29',
                    'judul' => 'Persiapan Ramadhan Bersama Remaja Masjid',
                    'deskripsi' => 'Relawan menata perlengkapan dan area masjid menjelang bulan suci.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'tanggal' => '2026-04-20',
                    'judul' => 'Pelatihan Khatib dan Imam',
                    'deskripsi' => 'Kegiatan pembinaan untuk meningkatkan kualitas dakwah dan ibadah berjamaah.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1470214304380-aadaedcfff3f?auto=format&fit=crop&w=1200&q=80',
                ],
                [
                    'tanggal' => '2026-04-15',
                    'judul' => 'Rapat Pengurus DKM Bulanan',
                    'deskripsi' => 'Forum evaluasi program masjid agar pelayanan kepada jamaah semakin baik.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80',
                ],
            ]);
        });
    @endphp

    <div class="frontend-page min-h-screen flex flex-col">
        @include('frontend.partials.navbar')

        <main class="flex-1">
            <section class="page-hero min-h-[70vh] flex items-center" data-aos="fade-up" style="background-image: linear-gradient(rgba(6,78,59,0.88), rgba(6,78,59,0.92)), url('{{ asset('storage/icon/FOTO.jpeg') }}'); background-size: cover; background-position: center;">
                <div class="page-shell py-16 sm:py-20">
                    <div class="relative z-10 max-w-3xl">
                        <p class="hero-badge">Galeri Kegiatan</p>
                        <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl">
                            Dokumentasi kegiatan masjid dalam tampilan yang rapi
                        </h1>
                        <p class="mt-5 text-base leading-8 text-emerald-50/85 sm:text-lg">
                            Foto-foto kegiatan ditampilkan dengan hover sederhana agar judul kegiatan tetap mudah dikenali saat dibuka di ponsel maupun desktop.
                        </p>
                    </div>
                </div>
            </section>

            <section class="page-section" data-aos="fade-up" data-aos-delay="80">
                <div class="mb-6 grid gap-4 md:grid-cols-3">
                    <div class="page-grid-note">Grid standar yang nyaman untuk jamaah umum.</div>
                    <div class="page-grid-note">Hover menampilkan judul kegiatan dengan jelas.</div>
                    <div class="page-grid-note">Cocok untuk dokumentasi rapat, kajian, dan santunan.</div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($galeriItems as $index => $item)
                        @php
                            $tanggal = \Illuminate\Support\Carbon::parse($item['tanggal'] ?? ($item->tanggal ?? now()))->translatedFormat('d M Y');
                            $thumb = $item['thumbnail'] ?? ($item->gambar ?? asset('storage/icon/foto.jpeg'));
                            $judul = $item['judul'] ?? ($item->judul ?? '');
                            $deskripsi = $item['deskripsi'] ?? ($item->keterangan ?? '');
                        @endphp

                        <article class="surface-card surface-card-soft overflow-hidden" data-aos="zoom-in" data-aos-delay="{{ 60 * ($index % 6) }}">
                            <div class="group relative aspect-[4/3] overflow-hidden bg-stone-100">
                                <img src="{{ $thumb }}" alt="{{ $judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/70 via-stone-950/10 to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                                <div class="absolute inset-x-0 bottom-0 p-5 opacity-0 transition duration-300 group-hover:opacity-100">
                                    <p class="text-[11px] font-black uppercase tracking-[0.24em] text-amber-300">{{ $tanggal }}</p>
                                    <h2 class="mt-2 text-lg font-black tracking-tight text-white">{{ $judul }}</h2>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-black tracking-tight text-stone-900">{{ $judul }}</h3>
                                <p class="mt-2 text-lg leading-7 text-stone-700">{{ \Illuminate\Support\Str::limit(strip_tags($deskripsi), 200) }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </main>

        @include('frontend.partials.footer')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.AOS) {
                AOS.init({
                    duration: 800,
                    once: true,
                    easing: 'ease-out-cubic'
                });
            }
        });
    </script>
</body>
</html>
