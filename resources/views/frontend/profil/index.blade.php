@extends('layouts.frontend')

@section('title', 'Profil Masjid - DKM Al-Musabaqoh')

@section('content')
    @php
        $sejarah = $profil?->sejarah ?? 'Masjid ini berdiri sebagai pusat ibadah dan pembinaan umat yang tumbuh bersama kebutuhan jamaah di lingkungan sekitar. Dalam perjalanannya, masjid terus berupaya menghadirkan suasana yang nyaman, tertib, dan bermanfaat untuk kegiatan ibadah, dakwah, dan sosial kemasyarakatan.';
        $visi = $profil?->visi ?? 'Menjadi masjid yang makmur, bersih, tertib, dan menjadi pusat pembinaan umat yang ramah bagi seluruh lapisan jamaah.';
        $misi = $profil?->misi ?? '1. Menyelenggarakan ibadah berjamaah dengan tertib dan khusyuk. 2. Menghidupkan kajian, dakwah, dan pembinaan generasi muda. 3. Mengelola masjid secara amanah, transparan, dan profesional. 4. Menjadi pusat layanan sosial yang mudah diakses jamaah.';
        $backgroundImage = asset('storage/icon/foto.webp');
        $pengurus = $pengurus ?? [];

        // Parse missions to list
        $misiItems = collect(str_contains($misi, "\n") ? preg_split('/[\r\n]+/', $misi) : preg_split('/\s*\d+[\.\)]\s+/', $misi))
            ->map(fn($item) => preg_replace('/^[^\p{L}\p{N}\(\"\']+/u', '', preg_replace('/^\d+[\.\)]\s*/u', '', trim($item))))
            ->map('trim')
            ->filter()
            ->values()
            ->all() ?: [
                'Menyelenggarakan ibadah berjamaah dengan tertib dan khusyuk.',
                'Menghidupkan kajian, dakwah, dan pembinaan generasi muda.',
                'Mengelola masjid secara amanah, transparan, dan profesional.',
                'Menjadi pusat layanan sosial yang mudah diakses jamaah.'
            ];
    @endphp

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
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col gap-10 sm:gap-12">
                <!-- Section Header (Title First) -->
                <div class="text-center" data-aos="fade-up">
                    <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Sejarah Masjid</p>
                    <h2 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-900 leading-tight font-display">
                        Perjalanan Tumbuh Bersama Jamaah
                    </h2>
                    <div class="mt-4 w-24 h-1 bg-gradient-to-r from-amber-400 to-amber-600 mx-auto rounded-full"></div>
                </div>

                <!-- Image Content (Carousel) Second -->
                <div data-aos="fade-up" data-aos-delay="100" class="relative w-full">
                    @php
                        $carouselImages = [
                            asset('storage/icon/foto.webp'),
                            asset('storage/icon/foto2.webp'),
                            asset('storage/icon/foto3.webp'),
                            asset('storage/icon/foto4.webp'),
                            asset('storage/icon/foto5.webp'),
                            asset('storage/icon/foto6.webp'),
                        ];
                    @endphp
                    <div x-data="{ 
                            activeSlide: 0, 
                            slides: {{ json_encode($carouselImages) }},
                            timer: null,
                            startTimer() {
                                this.timer = setInterval(() => {
                                    this.activeSlide = this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1;
                                }, 4000);
                            },
                            stopTimer() {
                                clearInterval(this.timer);
                            }
                        }" 
                        x-init="startTimer()" 
                        @mouseenter="stopTimer()" 
                        @mouseleave="startTimer()"
                        class="rounded-3xl overflow-hidden shadow-2xl border-8 border-amber-100/50 relative h-64 sm:h-96 lg:h-[500px] w-full group">
                        
                        <template x-for="(slide, index) in slides" :key="index">
                            <img :src="slide" 
                                alt="Dokumentasi Masjid Al-Musabaqoh" 
                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out"
                                :class="activeSlide === index ? 'opacity-100' : 'opacity-0'">
                        </template>

                        <!-- Navigation Arrows -->
                        <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/40 backdrop-blur-sm text-stone-900 flex items-center justify-center hover:bg-white/70 transition-all opacity-0 group-hover:opacity-100 shadow-md">
                            <i class="bi bi-chevron-left text-lg"></i>
                        </button>
                        <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/40 backdrop-blur-sm text-stone-900 flex items-center justify-center hover:bg-white/70 transition-all opacity-0 group-hover:opacity-100 shadow-md">
                            <i class="bi bi-chevron-right text-lg"></i>
                        </button>

                        <!-- Pagination Indicators -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="activeSlide = index" 
                                    class="h-2 rounded-full transition-all duration-300 shadow-sm"
                                    :class="activeSlide === index ? 'w-6 bg-amber-500' : 'w-2 bg-white/60 hover:bg-white/90'">
                                </button>
                            </template>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-amber-100/30 rounded-full blur-2xl"></div>
                </div>

                <!-- Text Content Third -->
                <div data-aos="fade-up" data-aos-delay="200" class="w-full">
                    <div class="sejarah-copy max-w-4xl mx-auto text-left">
                        <p class="text-lg sm:text-xl leading-relaxed text-stone-800 text-justify whitespace-pre-line font-medium">
                            {{ $sejarah }}
                        </p>
                    </div>
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
                <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border border-stone-200/50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 relative overflow-hidden"
                    data-aos="zoom-in" data-aos-delay="100">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-amber-400 to-amber-500"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-500 rounded-2xl flex items-center justify-center shadow-md">
                            <i class="bi bi-eye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-emerald-950 font-display">Visi</h3>
                    </div>
                    <div class="bg-stone-50 p-6 sm:p-8 rounded-2xl border border-stone-200/40 min-h-[150px] flex items-center">
                        <p class="text-xl sm:text-2xl leading-relaxed text-stone-800 font-bold italic text-center w-full">
                            "{{ $visi }}"
                        </p>
                    </div>
                </div>

                <!-- Misi Card -->
                <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border border-stone-200/50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 relative overflow-hidden"
                    data-aos="zoom-in" data-aos-delay="200">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-600 to-emerald-700"></div>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl flex items-center justify-center shadow-md">
                            <i class="bi bi-target text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-emerald-950 font-display">Misi</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($misiItems as $item)
                            <div class="flex items-start gap-4 bg-stone-50 hover:bg-stone-100/70 p-4 sm:p-5 rounded-2xl border border-stone-200/40 transition-colors duration-200">
                                <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-1 shadow-sm">
                                    <i class="bi bi-check2 text-sm font-bold"></i>
                                </div>
                                <p class="text-stone-850 font-semibold text-base sm:text-lg leading-relaxed text-justify">{{ $item }}</p>
                            </div>
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

            <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('frontend.profil.pengurus') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-900 px-8 py-4 text-base font-bold text-white transition hover:bg-emerald-800 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-200">
                    Lihat Susunan Pengurus Lengkap
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
