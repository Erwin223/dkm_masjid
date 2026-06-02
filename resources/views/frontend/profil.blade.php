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
            ['label' => 'Kegiatan', 'href' => route('frontend.kegiatan'), 'active' => request()->routeIs('frontend.kegiatan')],
            ['label' => 'Berita', 'href' => route('frontend.berita'), 'active' => request()->routeIs('frontend.berita')],
            ['label' => 'Galeri', 'href' => route('frontend.galeri'), 'active' => request()->routeIs('frontend.galeri')],
            ['label' => 'Laporan', 'href' => route('frontend.laporan'), 'active' => request()->routeIs('frontend.laporan')],
        ];

        $sejarah = $profil?->sejarah ?? 'Masjid ini berdiri sebagai pusat ibadah dan pembinaan umat yang tumbuh bersama kebutuhan jamaah di lingkungan sekitar. Dalam perjalanannya, masjid terus berupaya menghadirkan suasana yang nyaman, tertib, dan bermanfaat untuk kegiatan ibadah, dakwah, dan sosial kemasyarakatan.';
        $visi = $profil?->visi ?? 'Menjadi masjid yang makmur, bersih, tertib, dan menjadi pusat pembinaan umat yang ramah bagi seluruh lapisan jamaah.';
        $misi = $profil?->misi ?? '1. Menyelenggarakan ibadah berjamaah dengan tertib dan khusyuk. 2. Menghidupkan kajian, dakwah, dan pembinaan generasi muda. 3. Mengelola masjid secara amanah, transparan, dan profesional. 4. Menjadi pusat layanan sosial yang mudah diakses jamaah.';
        $backgroundImage = asset('storage/icon/FOTO.jpeg');
        $pengurus = $pengurus ?? [];
    @endphp

    <div class="frontend-page min-h-screen flex flex-col">
        @include('frontend.partials.navbar')

        <main class="flex-1">
            <x-hero-banner
                badge="Profil Masjid"
                title="Profil Masjid"
                accent="Al-Musabaqoh"
                subtitle="Pusat ibadah dan pembinaan umat yang terus berupaya menghadirkan suasana nyaman, tertib, dan bermanfaat untuk jamaah."
                :bg-image="$backgroundImage"
                icon="bi-building"
                badge-icon="bi-building"
                cta-label="Lihat Profil Lengkap"
                cta-href="#sejarah"
            />

            <!-- ===== SEJARAH MASJID SECTION ===== -->
            <section id="sejarah" class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-white" data-aos="fade-up">
                <div class="max-w-7xl mx-auto">
                    <div class="grid gap-12 lg:gap-16 lg:grid-cols-2 items-center">
                        <!-- Text Content -->
                        <div data-aos="fade-right" data-aos-delay="100">
                            <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Sejarah Masjid</p>
                            <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-900 leading-tight">
                                Perjalanan Tumbuh Bersama Jamaah
                            </h2>
                            <p class="mt-6 text-lg leading-relaxed text-stone-700">
                                {{ $sejarah }}
                            </p>
                            <div class="mt-8 flex gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-1 h-12 bg-gradient-to-b from-amber-400 to-transparent"></div>
                                    <div>
                                        <p class="text-2xl font-bold text-emerald-900">{{ count($pengurus) }}</p>
                                        <p class="text-sm text-stone-600">Pengurus Aktif</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Content -->
                        <div data-aos="fade-left" data-aos-delay="100" class="relative">
                            <div class="rounded-3xl overflow-hidden shadow-2xl border-8 border-amber-100">
                                <img src="{{ $backgroundImage }}" 
                                    alt="Masjid Al-Musabaqoh" 
                                    class="w-full h-96 object-cover">
                            </div>
                            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-amber-100/30 rounded-full blur-2xl"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===== VISI & MISI SECTION ===== -->
            <section class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-emerald-50 to-emerald-100/50" data-aos="fade-up">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Arah & Tujuan</p>
                        <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-900">
                            Visi & Misi Kami
                        </h2>
                    </div>

                    <div class="grid gap-8 lg:gap-12 lg:grid-cols-2">
                        <!-- Visi Card -->
                        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border-l-8 border-amber-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                            data-aos="zoom-in" data-aos-delay="100">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-500 rounded-full flex items-center justify-center">
                                    <i class="bi bi-eye text-white text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-emerald-900">Visi</h3>
                            </div>
                            <p class="text-lg leading-relaxed text-stone-700">
                                {{ $visi }}
                            </p>
                        </div>

                        <!-- Misi Card -->
                        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border-l-8 border-emerald-600 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                            data-aos="zoom-in" data-aos-delay="200">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-full flex items-center justify-center">
                                    <i class="bi bi-target text-white text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-emerald-900">Misi</h3>
                            </div>
                            <div class="space-y-3 text-stone-700 leading-relaxed">
                                @foreach(preg_split('/\d+\.\s+/', trim($misi)) as $item)
                                    @if(!empty(trim($item)))
                                        <div class="flex gap-3">
                                            <i class="bi bi-check-circle-fill text-amber-400 mt-1 flex-shrink-0"></i>
                                            <p class="text-base">{{ trim($item) }}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ===== STRUKTUR KEPENGURUSAN SECTION ===== -->
            <section class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-white" data-aos="fade-up">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-16">
                        <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Organisasi</p>
                        <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-900">
                            Struktur Kepengurusan DKM
                        </h2>
                        <p class="mt-4 text-lg text-stone-600 max-w-2xl mx-auto leading-relaxed">
                            Berikut adalah susunan pengurus inti yang memimpin dan mengelola Masjid Al-Musabaqoh
                        </p>
                    </div>

                    @if(count($pengurus) > 0)
                        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($pengurus as $item)
                                <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-stone-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                                    data-aos="zoom-in" data-aos-delay="{{ 100 + ($loop->index * 50) }}">
                                    
                                    <!-- Photo Section -->
                                    @if(!empty($item['foto']))
                                        <div class="relative h-48 bg-gradient-to-br from-emerald-100 to-amber-50 overflow-hidden">
                                            <img src="{{ $item['foto'] }}" 
                                                alt="{{ $item['nama'] }}" 
                                                class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                        </div>
                                    @else
                                        <div class="h-48 bg-gradient-to-br from-emerald-400 to-amber-300 flex items-center justify-center">
                                            <i class="bi bi-person-circle text-white text-6xl"></i>
                                        </div>
                                    @endif

                                    <!-- Content Section -->
                                    <div class="p-6 sm:p-8">
                                        <p class="text-xs font-bold tracking-widest uppercase text-amber-600">
                                            {{ $item['jabatan'] ?? 'Pengurus' }}
                                        </p>
                                        <h3 class="mt-3 text-2xl font-black text-emerald-900">
                                            {{ $item['nama'] ?? 'Nama Pengurus' }}
                                        </h3>
                                        <p class="mt-2 text-sm font-semibold text-stone-600">
                                            {{ $item['jabatan'] ?? 'Pengurus DKM' }}
                                        </p>
                                        <p class="mt-4 text-base leading-relaxed text-stone-700">
                                            {{ $item['tugas'] ?? 'Deskripsi tugas belum diisi oleh admin.' }}
                                        </p>
                                        
                                        @if(!empty($item['no_hp']))
                                            <div class="mt-5 pt-5 border-t border-stone-200">
                                                <p class="text-sm text-stone-500">
                                                    <i class="bi bi-telephone text-amber-600 mr-2"></i>
                                                    {{ $item['no_hp'] }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-amber-50 border-2 border-amber-200 rounded-3xl p-12 text-center">
                            <i class="bi bi-info-circle text-3xl text-amber-600 mb-4"></i>
                            <p class="text-lg font-semibold text-stone-700">
                                Data pengurus belum tersedia
                            </p>
                            <p class="mt-2 text-stone-600">
                                Silakan lengkapi data pengurus di admin panel
                            </p>
                        </div>
                    @endif
                </div>
            </section>

            <!-- ===== CTA SECTION ===== -->
            <section class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-emerald-900 to-emerald-800" data-aos="fade-up">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                        Ingin Bergabung atau Berkontribusi?
                    </h2>
                    <p class="mt-6 text-lg text-emerald-50/90 leading-relaxed max-w-2xl mx-auto">
                        Masjid Al-Musabaqoh selalu terbuka untuk menerima jamaah dan kontribusi dari masyarakat dalam berbagai bentuk kegiatan ibadah dan sosial.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('frontend.home') }}#donasi" 
                            class="px-8 py-4 bg-amber-400 text-emerald-900 font-bold rounded-full hover:bg-amber-300 transition-all duration-300 text-lg inline-flex items-center gap-2">
                            <i class="bi bi-heart-fill"></i> Donasi & Infak
                        </a>
                        <a href="{{ route('frontend.berita') }}" 
                            class="px-8 py-4 border-2 border-amber-400 text-amber-400 font-bold rounded-full hover:bg-amber-400/10 transition-all duration-300 text-lg inline-flex items-center gap-2">
                            <i class="bi bi-newspaper"></i> Lihat Berita Terbaru
                        </a>
                        <a href="{{ route('frontend.home') }}#kegiatan" 
                            class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 transition-all duration-300 text-lg inline-flex items-center gap-2">
                            <i class="bi bi-calendar-check"></i> Jadwal Kegiatan
                        </a>
                    </div>
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
                    easing: 'ease-out-cubic',
                    offset: 100
                });
            }
        });
    </script>
</body>

</html>
