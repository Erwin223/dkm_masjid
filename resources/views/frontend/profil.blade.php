<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Masjid - DKM Al-Musabaqoh</title>
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

        $sejarah = $profil?->sejarah ?? 'Masjid ini berdiri sebagai pusat ibadah dan pembinaan umat yang tumbuh bersama kebutuhan jamaah di lingkungan sekitar. Dalam perjalanannya, masjid terus berupaya menghadirkan suasana yang nyaman, tertib, dan bermanfaat untuk kegiatan ibadah, dakwah, dan sosial kemasyarakatan.';
        $visi = $profil?->visi ?? 'Menjadi masjid yang makmur, bersih, tertib, dan menjadi pusat pembinaan umat yang ramah bagi seluruh lapisan jamaah.';
        $misi = $profil?->misi ?? '1. Menyelenggarakan ibadah berjamaah dengan tertib dan khusyuk. 2. Menghidupkan kajian, dakwah, dan pembinaan generasi muda. 3. Mengelola masjid secara amanah, transparan, dan profesional. 4. Menjadi pusat layanan sosial yang mudah diakses jamaah.';
        $backgroundImage = asset('storage/icon/FOTO.jpeg');

        $pengurus = $pengurus ?? [
            ['jabatan' => 'Ketua DKM', 'nama' => 'Ustadz Ahmad Fauzi', 'tugas' => 'Memimpin arah kebijakan umum, mengoordinasikan program, dan memastikan pelayanan jamaah berjalan tertib.'],
            ['jabatan' => 'Sekretaris', 'nama' => 'H. Abdul Karim', 'tugas' => 'Mengelola administrasi, surat-menyurat, dan dokumentasi kegiatan masjid.'],
            ['jabatan' => 'Bendahara', 'nama' => 'Hj. Siti Rahmah', 'tugas' => 'Mengelola kas, laporan keuangan, dan transparansi donasi serta infak jamaah.'],
            ['jabatan' => 'Bidang Ibadah', 'nama' => 'Ustadz Yusuf Hidayat', 'tugas' => 'Menyiapkan kegiatan rutin, imam, kajian, dan agenda ibadah harian.'],
        ];
    @endphp

    <div class="frontend-page min-h-screen flex flex-col">
        @include('frontend.partials.navbar')

        <main class="flex-1">
            <section class="page-hero min-h-[80vh] flex items-center" data-aos="fade-up" data-aos-delay="80" style="background-image: linear-gradient(135deg, rgba(6, 78, 59, 0.96), rgba(15, 23, 42, 0.92)), url('{{ asset('storage/icon/FOTO.jpeg') }}'); background-size: cover; background-position: center;">
                <div class="page-shell py-16 sm:py-20">
                    <div class="relative z-10 grid gap-8 lg:grid-cols-[1.25fr_.75fr] lg:items-end">
                        <div class="max-w-3xl">
                            <p class="hero-badge">Profil Masjid</p>
                            <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl">
                                Informasi ringkas masjid untuk jamaah dan pengurus
                            </h1>
                            <p class="mt-5 max-w-2xl text-base leading-8 text-emerald-50/85 sm:text-lg">
                                Halaman ini menyajikan sejarah singkat masjid, arah visi misi, dan struktur kepengurusan DKM dalam susunan yang rapi, bersih, dan mudah dibaca.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="page-section" data-aos="fade-up" data-aos-delay="120">
                <div class="grid gap-8 lg:grid-cols-[1.3fr_.7fr]">
                    <article class="surface-card surface-card-soft lg:col-span-1" data-aos="zoom-in">
                        <div class="border-b border-stone-100 px-6 py-5 sm:px-8">
                            <p class="section-kicker">Sejarah Singkat Masjid</p>
                            <h2 class="section-heading">Perjalanan tumbuh bersama jamaah</h2>
                        </div>
                        <div class="px-6 py-6 sm:px-8">
                            <p class="text-lg leading-8 text-stone-800">{{ $profil?->sejarah ?? $sejarah }}</p>
                        </div>
                    </article>

                    <aside class="surface-card surface-card-soft overflow-hidden" data-aos="zoom-in" data-aos-delay="160">
                        <div class="aspect-[4/4] w-full overflow-hidden bg-emerald-100">
                            <div class="h-full w-full bg-center bg-cover transition duration-500 hover:scale-105" style="background-image: url('{{ $backgroundImage }}');"></div>
                        </div>
                        <div class="p-6">
                            <p class="section-kicker">Ketua DKM</p>
                            <h2 class="mt-2 text-xl font-black tracking-tight text-stone-900">Ustadz Ahmad Fauzi</h2>
                            <p class="mt-4 text-sm leading-7 text-stone-600">
                                Memimpin pengurus dengan pendekatan yang tertib, komunikatif, dan mengutamakan kenyamanan jamaah dalam setiap pelayanan masjid.
                            </p>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="page-section pt-0" data-aos="fade-up">
                <div class="grid gap-8 lg:grid-cols-2">
                    <article class="surface-card surface-card-soft p-6 sm:p-8" data-aos="zoom-in">
                        <p class="section-kicker">Visi</p>
                        <h2 class="section-heading">Arah besar masjid</h2>
                        <p class="mt-4 text-lg leading-8 text-stone-800">{{ $profil?->visi ?? $visi }}</p>
                    </article>

                    <article class="surface-card surface-card-soft p-6 sm:p-8" data-aos="zoom-in" data-aos-delay="80">
                        <p class="section-kicker">Misi</p>
                        <h2 class="section-heading">Langkah kerja yang jelas</h2>
                        <p class="mt-4 whitespace-pre-line text-lg leading-8 text-stone-800">{{ $profil?->misi ?? $misi }}</p>
                    </article>
                </div>
            </section>

            <section class="page-section" data-aos="fade-up" data-aos-delay="120">
                <div class="mb-8 max-w-2xl">
                    <p class="section-kicker">Struktur Kepengurusan DKM</p>
                    <h2 class="section-heading">Susunan pengurus inti</h2>
                  
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($pengurus as $item)
                        <article class="surface-card surface-card-soft p-6" data-aos="zoom-in">
                            <p class="text-[11px] font-extrabold uppercase tracking-[0.24em] text-amber-700">{{ $item['jabatan'] }}</p>

                            @if(!empty($item['foto']))
                                <div class="mt-3 mb-2 w-20 h-20 rounded-full overflow-hidden">
                                    <img src="{{ $item['foto'] }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover object-center">
                                </div>
                            @endif

                            <h3 class="mt-3 text-lg font-black tracking-tight text-stone-900">{{ $item['nama'] }}</h3>
                            <p class="mt-3 text-lg leading-7 text-stone-700">{{ $item['tugas'] ?? 'Deskripsi tugas belum diisi oleh admin.' }}</p>
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
