@extends('layouts.frontend')

@section('title', 'Jadwal Kegiatan Masjid - DKM Al-Musabaqoh')

@section('content')
    @php
        $today = \Carbon\Carbon::today();
    @endphp

    <x-hero-banner
        badge="Jadwal Lengkap Kegiatan Masjid"
        title="Jadwal Kegiatan"
        accent="Masjid Al-Musabaqoh"
        subtitle="Informasi lengkap mengenai kajian, sholat berjamaah, dan kegiatan sosial kemasyarakatan yang kami selenggarakan untuk mendekatkan diri kepada Allah SWT."
        :bg-image="asset('storage/icon/FOTO.jpeg')"
        icon="bi-calendar-week"
        badge-icon="bi-calendar-check"
        cta-label="Lihat Jadwal Lengkap"
        cta-href="#kegiatan-list"
    />

    <!-- ===== NEXT UPCOMING EVENT HIGHLIGHT ===== -->
    @if($nextKegiatan)
        <section class="py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-stone-50 to-stone-100">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8" data-aos="fade-up">
                    <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Kegiatan Terdekat</p>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-black text-emerald-900">Acara Selanjutnya</h2>
                </div>

                @php
                    $tanggal = \Carbon\Carbon::parse($nextKegiatan['tanggal'] ?? $nextKegiatan->tanggal);
                    $hari = $tanggal->translatedFormat('l');
                    $bulan = $tanggal->translatedFormat('d F Y');
                    $waktu = $nextKegiatan['waktu'] ?? $nextKegiatan->waktu ?? 'Waktu belum ditentukan';
                    $tempat = $nextKegiatan['tempat'] ?? $nextKegiatan->tempat ?? 'Lokasi belum ditentukan';
                    $nama = $nextKegiatan['nama_kegiatan'] ?? $nextKegiatan->nama_kegiatan ?? 'Kegiatan';
                    $pemateri = $nextKegiatan['penanggung_jawab'] ?? $nextKegiatan->penanggung_jawab ?? 'Tim Pengurus';
                @endphp

                <div class="bg-gradient-to-br from-white to-stone-50 rounded-3xl border-2 border-emerald-200 p-8 sm:p-10 lg:p-12 shadow-lg hover:shadow-xl transition-all duration-300" 
                    data-aos="zoom-in" data-aos-delay="100">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                        <!-- Left: Date & Time -->
                        <div class="flex gap-6">
                            <!-- Calendar Box -->
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 sm:w-28 sm:h-28 bg-gradient-to-br from-amber-400 to-amber-50 rounded-2xl flex flex-col items-center justify-center shadow-lg border-4 border-amber-300/50">
                                    <p class="text-white text-xs font-bold uppercase tracking-widest">{{ $tanggal->format('M') }}</p>
                                    <p class="text-white text-3xl sm:text-4xl font-black">{{ $tanggal->format('d') }}</p>
                                </div>
                            </div>

                            <!-- Date Info -->
                            <div class="flex flex-col justify-center">
                                <p class="text-amber-600 font-bold text-sm uppercase tracking-wider">{{ $hari }}</p>
                                <h3 class="mt-1 text-stone-600 text-lg font-semibold">{{ $bulan }}</h3>
                                <div class="mt-2 flex items-center gap-2 text-emerald-700">
                                    <i class="bi bi-clock-fill text-lg"></i>
                                    <span class="font-bold text-base">{{ $waktu }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Center: Event Details -->
                        <div class="lg:col-span-1">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-stone-500 text-xs font-bold uppercase tracking-wider mb-1">Kegiatan</p>
                                    <h4 class="text-2xl sm:text-3xl font-black text-emerald-900 leading-snug">{{ $nama }}</h4>
                                </div>
                                <div>
                                    <p class="text-stone-500 text-xs font-bold uppercase tracking-wider mb-1">Pemateri / Penanggung Jawab</p>
                                    <p class="text-lg font-bold text-stone-700">{{ $pemateri }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Location & Icon -->
                        <div class="flex flex-col items-start lg:items-end gap-4">
                            <div class="flex items-start gap-3 w-full lg:justify-end">
                                <i class="bi bi-geo-alt-fill text-emerald-600 text-2xl flex-shrink-0 mt-1"></i>
                                <div class="text-right">
                                    <p class="text-stone-500 text-xs font-bold uppercase tracking-wider">Lokasi</p>
                                    <p class="text-base sm:text-lg font-bold text-stone-800">{{ $tempat }}</p>
                                </div>
                            </div>
                            <a href="#kegiatan-list" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 transition-all duration-300">
                                <i class="bi bi-arrow-down-short"></i> Lihat Jadwal Lainnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ===== MAIN KEGIATAN LIST (TIMELINE) ===== -->
    <section class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-white" id="kegiatan-list" data-aos="fade-up">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12">
                <p class="text-amber-600 font-bold text-sm tracking-widest uppercase">Daftar Lengkap</p>
                <h2 class="mt-2 text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-900">Jadwal Kegiatan</h2>
                <p class="mt-4 text-lg text-stone-600 leading-relaxed">
                    Berikut adalah daftar lengkap kegiatan yang akan kami selenggarakan. Semua jamaah diundang untuk berpartisipasi sesuai dengan jangka waktu dan minat.
                </p>
            </div>

            @forelse($jadwal_kegiatan ?? [] as $index => $kegiatan)
                @php
                    $kegiatanTanggal = \Carbon\Carbon::parse($kegiatan['tanggal'] ?? $kegiatan->tanggal);
                    $kegiatanHari = $kegiatanTanggal->translatedFormat('l');
                    $kegiatanBulan = $kegiatanTanggal->translatedFormat('d M Y');
                    $kegiatanWaktu = $kegiatan['waktu'] ?? $kegiatan->waktu ?? 'Waktu belum ditentukan';
                    $kegiatanTempat = $kegiatan['tempat'] ?? $kegiatan->tempat ?? 'Lokasi belum ditentukan';
                    $kegiatanNama = $kegiatan['nama_kegiatan'] ?? $kegiatan->nama_kegiatan ?? 'Kegiatan';
                    $kegiatanPemateri = $kegiatan['penanggung_jawab'] ?? $kegiatan->penanggung_jawab ?? 'Tim Pengurus';
                    $kegiatanKeterangan = $kegiatan['keterangan'] ?? $kegiatan->keterangan ?? '';
                    $kegiatanHijri = $kegiatan->tanggal_hijri ?? '';
                    
                    // Determine category/icon
                    $categoryIcon = 'bi-book-fill';
                    $categoryColor = 'emerald';
                    if (str_contains(strtolower($kegiatanNama), 'bersih')) {
                        $categoryIcon = 'bi-broom-fill';
                        $categoryColor = 'blue';
                    } elseif (str_contains(strtolower($kegiatanNama), 'santunan') || str_contains(strtolower($kegiatanNama), 'sosial')) {
                        $categoryIcon = 'bi-heart-fill';
                        $categoryColor = 'red';
                    } elseif (str_contains(strtolower($kegiatanNama), 'rapat')) {
                        $categoryIcon = 'bi-chat-dots-fill';
                        $categoryColor = 'yellow';
                    } elseif (str_contains(strtolower($kegiatanNama), 'mengaji')) {
                        $categoryIcon = 'bi-book-fill';
                        $categoryColor = 'purple';
                    }
                @endphp

                <div class="relative mb-8 pb-8 last:pb-0 last:mb-0" 
                    data-aos="fade-up" data-aos-delay="{{ 50 * ($index % 5) }}">
                    
                    <!-- Timeline Connector -->
                    <div class="absolute left-11 sm:left-14 top-24 bottom-0 w-1 bg-gradient-to-b from-emerald-400 to-emerald-200 last:hidden"></div>

                    <div class="flex gap-4 sm:gap-6">
                        <!-- Date/Calendar Icon -->
                        <div class="flex-shrink-0">
                            <div class="relative w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl flex flex-col items-center justify-center border-2 border-emerald-200 shadow-md hover:shadow-lg transition-all duration-300 z-10">
                                <p class="text-emerald-700 text-xs font-bold uppercase tracking-wider">{{ $kegiatanTanggal->format('M') }}</p>
                                <p class="text-emerald-900 text-2xl sm:text-3xl font-black">{{ $kegiatanTanggal->format('d') }}</p>
                                <p class="text-emerald-600 text-[10px] font-bold uppercase">{{ $kegiatanHari }}</p>
                            </div>
                        </div>

                        <!-- Event Card -->
                        <div class="flex-1 bg-white border border-stone-200 rounded-2xl p-5 sm:p-6 hover:shadow-lg hover:border-emerald-300 transition-all duration-300">
                            <!-- Badges (Category & Status) -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <!-- Category Badge -->
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-bold uppercase tracking-wider
                                    @if($categoryColor === 'emerald') bg-emerald-50 text-emerald-700 border-emerald-100
                                    @elseif($categoryColor === 'blue') bg-blue-50 text-blue-700 border-blue-100
                                    @elseif($categoryColor === 'red') bg-red-50 text-red-700 border-red-100
                                    @elseif($categoryColor === 'yellow') bg-yellow-50 text-yellow-700 border-yellow-100
                                    @elseif($categoryColor === 'purple') bg-purple-50 text-purple-700 border-purple-100
                                    @else bg-stone-50 text-stone-700 border-stone-200 @endif">
                                    <i class="bi {{ $categoryIcon }} text-sm"></i>
                                    <span>
                                        @if(str_contains(strtolower($kegiatanNama), 'bersih'))
                                            Kebersihan
                                        @elseif(str_contains(strtolower($kegiatanNama), 'santunan') || str_contains(strtolower($kegiatanNama), 'sosial'))
                                            Sosial
                                        @elseif(str_contains(strtolower($kegiatanNama), 'rapat'))
                                            Koordinasi
                                        @elseif(str_contains(strtolower($kegiatanNama), 'mengaji'))
                                            Kajian Pendidikan
                                        @else
                                            Kegiatan
                                        @endif
                                    </span>
                                </div>

                                <!-- Status Badge -->
                                @if($kegiatanTanggal->isToday() || $kegiatanTanggal->isFuture())
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200/50 text-xs font-bold uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                                        <span>Kegiatan yang akan datang</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-stone-100 text-stone-500 border border-stone-200/60 text-xs font-bold uppercase tracking-wider">
                                        <i class="bi bi-check2 text-xs font-black"></i>
                                        <span>Kegiatan telah dilaksanakan</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg sm:text-xl font-black text-emerald-900 leading-snug mb-2 font-display">
                                {{ $kegiatanNama }}
                            </h3>

                            <!-- Subtitle: Pemateri/Penanggung Jawab -->
                            @if($kegiatanPemateri)
                                <p class="text-sm sm:text-base font-semibold text-stone-600 mb-4">
                                    <i class="bi bi-person-circle text-emerald-600 mr-2"></i>
                                    {{ $kegiatanPemateri }}
                                </p>
                            @endif

                            <!-- Details Grid (Gregorian Date, Time, Location, Hijri Date) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4 bg-stone-50 p-4 rounded-2xl border border-stone-150/50">
                                <!-- Gregorian Date -->
                                <div class="flex items-center gap-2 text-stone-700">
                                    <i class="bi bi-calendar3 text-emerald-600 text-lg flex-shrink-0"></i>
                                    <div>
                                        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Masehi</p>
                                        <p class="text-sm font-bold">{{ $kegiatanBulan }}</p>
                                    </div>
                                </div>

                                <!-- Hijri Date -->
                                <div class="flex items-center gap-2 text-stone-700">
                                    <i class="bi bi-moon-stars-fill text-amber-600 text-lg flex-shrink-0"></i>
                                    <div>
                                        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Hijriah</p>
                                        <p class="text-sm font-bold">{{ $kegiatanHijri }}</p>
                                    </div>
                                </div>

                                <!-- Time -->
                                <div class="flex items-center gap-2 text-stone-700">
                                    <i class="bi bi-clock-fill text-amber-500 text-lg flex-shrink-0"></i>
                                    <div>
                                        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Waktu</p>
                                        <p class="text-sm font-bold">{{ $kegiatanWaktu }}</p>
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="flex items-center gap-2 text-stone-700">
                                    <i class="bi bi-geo-alt-fill text-red-500 text-lg flex-shrink-0"></i>
                                    <div>
                                        <p class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Lokasi</p>
                                        <p class="text-sm font-bold leading-tight">{{ $kegiatanTempat }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($kegiatanKeterangan)
                                <p class="text-sm text-stone-600 leading-relaxed pt-3 border-t border-stone-100">
                                    {{ $kegiatanKeterangan }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="py-16 sm:py-20 text-center" data-aos="fade-up">
                    <div class="mb-6">
                        <i class="bi bi-calendar-x text-7xl text-stone-200 block"></i>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-stone-700 mb-2">Belum Ada Jadwal Kegiatan</h3>
                    <p class="text-lg text-stone-600 leading-relaxed max-w-md mx-auto">
                        Belum ada jadwal kegiatan baru yang ditambahkan bulan ini. Silakan cek kembali nanti atau hubungi pengurus untuk informasi lebih lanjut.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('frontend.home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-bold rounded-full hover:bg-emerald-700 transition-all duration-300">
                            <i class="bi bi-arrow-left-short"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Pagination Controls -->
            @if($jadwal_kegiatan instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $jadwal_kegiatan->hasPages())
                <div class="mt-12 flex items-center justify-between border-t border-stone-200 pt-6">
                    <!-- Prev Page Link -->
                    @if($jadwal_kegiatan->onFirstPage())
                        <span class="inline-flex items-center gap-1 px-4 py-2 text-stone-300 text-sm font-extrabold cursor-not-allowed">
                            <i class="bi bi-arrow-left"></i> Sebelumnya
                        </span>
                    @else
                        <a href="{{ $jadwal_kegiatan->previousPageUrl() }}" class="inline-flex items-center gap-1 px-4 py-2 text-emerald-700 hover:text-emerald-800 text-sm font-extrabold transition">
                            <i class="bi bi-arrow-left"></i> Sebelumnya
                        </a>
                    @endif

                    <!-- Page Numbers Info -->
                    <span class="text-xs text-stone-500 font-bold uppercase tracking-widest">
                        Halaman {{ $jadwal_kegiatan->currentPage() }} dari {{ $jadwal_kegiatan->lastPage() }}
                    </span>

                    <!-- Next Page Link -->
                    @if($jadwal_kegiatan->hasMorePages())
                        <a href="{{ $jadwal_kegiatan->nextPageUrl() }}" class="inline-flex items-center gap-1 px-4 py-2 text-emerald-700 hover:text-emerald-800 text-sm font-extrabold transition">
                            Selanjutnya <i class="bi bi-arrow-right"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1 px-4 py-2 text-stone-300 text-sm font-extrabold cursor-not-allowed">
                            Selanjutnya <i class="bi bi-arrow-right"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- ===== CALL-TO-ACTION SECTION ===== -->
    <section class="py-16 sm:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-emerald-900 to-emerald-800" data-aos="fade-up">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight mb-6">
                Jadilah Bagian dari Komunitas Jamaah
            </h2>
            <p class="text-lg text-emerald-50/90 leading-relaxed mb-8 max-w-2xl mx-auto">
                Kami mengundang seluruh jamaah untuk berpartisipasi aktif dalam setiap kegiatan yang kami selenggarakan. Bersama kita tumbuh dalam iman dan amal sholeh.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('frontend.home') }}#berita" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-amber-400 text-emerald-900 font-bold rounded-full hover:bg-amber-300 transition-all duration-300">
                    <i class="bi bi-newspaper"></i> Baca Berita Terbaru
                </a>
                <a href="{{ route('frontend.profil') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-amber-400 text-amber-400 font-bold rounded-full hover:bg-amber-400/10 transition-all duration-300">
                    <i class="bi bi-people-fill"></i> Struktur Pengurus
                </a>
            </div>
        </div>
    </section>
@endsection
