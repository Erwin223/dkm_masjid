@extends('layouts.frontend')

@section('title', 'DKM Al-Musabaqoh Subang - Portal Resmi Pelayanan Jamaah')

@section('content')

<section class="relative min-h-[85vh] flex flex-col justify-center islamic-pattern text-white pt-10 pb-28 md:pb-40 px-4" id="beranda" style="background-image: linear-gradient(rgba(6,78,59,0.88), rgba(6,78,59,0.92)), url('{{ asset('storage/icon/FOTO.jpeg') }}'); background-size: cover; background-position: center;">

    <div class="absolute top-10 right-10 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">

        <div class="hidden lg:flex lg:col-span-4 justify-center reveal reveal-left delay-1">
            <div class="w-80 h-80 rounded-full bg-white p-6 flex items-center justify-center shadow-2xl relative">
                <img src="{{ asset('favicon.ico') }}" alt="Logo DKM Al-Musabaqoh" class="w-full h-full object-contain rounded-full">
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6 text-left reveal reveal-right delay-2">

            <div class="inline-flex items-center gap-2.5 bg-amber-500/10 border border-amber-500/25 px-4 py-2 rounded-full text-xs font-extrabold uppercase tracking-widest text-amber-400 backdrop-blur-md">
                <i class="bi bi-patch-check-fill"></i> Portal Layanan & Transparansi Pengurus
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tight leading-tight font-display">
                Selamat Datang Di <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-300">DKM Al-Musabaqoh Subang</span>
            </h1>

            <p class="text-sm sm:text-base md:text-lg text-emerald-100/90 max-w-2xl leading-relaxed">
                Selamat datang di portal informasi resmi Masjid Agung Al-Musabaqoh Subang. Kami hadir sebagai sarana penyiaran jadwal sholat presisi, pengumuman kegiatan dakwah, transparansi keuangan kas, serta wadah infak sedekah digital terpercaya untuk kemakmuran masjid dan jamaah.
            </p>

            <div class="relative w-full max-w-xl" id="searchContainer">
                <form class="flex flex-col sm:flex-row gap-3 w-full bg-white/5 border border-white/15 p-2 rounded-2xl backdrop-blur-xl shadow-xl focus-within:border-amber-400/50 transition-all duration-300" id="quickSearchForm">
                    <div class="flex items-center gap-3 px-3 flex-1">
                        <i class="bi bi-search text-amber-500 text-lg"></i>
                        <input
                            type="text"
                            id="quickSearchInput"
                            placeholder="Cari menu: berita, donasi, kegiatan..."
                            autocomplete="off"
                            class="w-full bg-transparent border-0 outline-none text-white placeholder-emerald-200/50 text-sm font-medium py-2.5">
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-stone-950 font-bold text-sm px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-1.5">
                        Cari <i class="bi bi-arrow-right-short text-lg"></i>
                    </button>
                </form>

                <!-- Search Dropdown Results -->
                <div
                    id="searchDropdown"
                    class="absolute top-full left-0 right-0 mt-2 bg-emerald-950 border border-emerald-800 rounded-2xl shadow-2xl overflow-hidden z-50 hidden"
                    role="listbox"
                    aria-label="Hasil pencarian cepat">
                    <ul id="searchDropdownList" class="divide-y divide-emerald-800/60"></ul>
                    <div id="searchDropdownEmpty" class="hidden px-5 py-4 text-sm text-emerald-200/70 font-medium text-center">
                        <i class="bi bi-search text-amber-400 mr-1"></i>
                        Tidak ada hasil untuk kata kunci tersebut.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Core Wrap -->
<main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 relative z-20">

    <!-- Prayer Schedule Dashboard Panel -->
    <div class="prayer-panel-wrap reveal reveal-up delay-3">
        <div class="prayer-panel bg-white rounded-3xl p-6 md:p-8 shadow-xl border border-stone-100">

            <div class="panel-frame grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Left Panel: Hitung Mundur Sholat -->
                <div id="countdownBox" class="lg:col-span-5 bg-gradient-to-br from-emerald-900 to-emerald-950 text-white rounded-2xl p-6 md:p-8 relative overflow-hidden flex items-center shadow-lg border border-emerald-800/50">
                    <div class="absolute inset-0 bg-radial-at-t from-white/5 to-transparent pointer-events-none"></div>
                    <div class="moon-shape"></div>

                    <div class="countdown-main w-full space-y-4">
                        <div class="status-loading flex items-center gap-2 text-stone-300 font-medium">
                            <span class="w-4 h-4 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></span> Memuat waktu sholat...
                        </div>
                    </div>
                </div>

                <!-- Right Panel: Rotasi Kutipan Hadits/Quran -->
                <div class="lg:col-span-7 bg-stone-50 border border-stone-100 rounded-2xl p-6 md:p-8 flex flex-col justify-center relative overflow-hidden">
                    <div class="quote-icon text-stone-100 absolute -top-5 -left-5 text-9xl font-serif leading-none select-none">“</div>
                    <div class="relative z-10 space-y-4">
                        <h3 class="text-xs font-black uppercase tracking-widest text-emerald-700 flex items-center gap-2">
                            <i class="bi bi-bookmark-star-fill text-amber-500"></i> Cahaya Hikmah
                        </h3>
                        <p id="quoteText" class="text-stone-800 text-base md:text-lg font-medium italic leading-relaxed">
                            "{{ $quotes[0]['text'] }}"
                        </p>
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-2 pt-2 border-t border-stone-200/60">
                            <small id="quoteSource" class="text-xs font-bold text-amber-700">— {{ $quotes[0]['source'] }}</small>
                            <div class="text-[10px] font-bold text-stone-400 uppercase tracking-widest" id="quoteDate">{{ $quotes[0]['date'] }}</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Prayer Times Row (Dynamically populated by JS) -->
            <div id="prayerTimes" class="grid grid-cols-1 sm:grid-cols-5 gap-3 mt-6">
                <div class="status-loading py-6 text-center text-stone-400 font-semibold col-span-5 bg-stone-50 rounded-xl">
                    <span class="w-5 h-5 border-2 border-primary-500 border-t-transparent rounded-full animate-spin inline-block align-middle mr-2"></span> Menyiapkan waktu sholat...
                </div>
            </div>

            <!-- Schedule Tools Footer -->
            <div class="sholat-tools flex flex-col sm:flex-row items-center justify-between gap-4 mt-6 pt-6 border-t border-stone-100">
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <span class="api-source text-[11px] font-bold text-stone-400 uppercase tracking-widest inline-flex items-center gap-1.5">
                        <i class="bi bi-info-circle text-amber-600 text-sm"></i> Kemenag RI via api.myquran.com
                    </span>

                    <!-- City Selector Form -->
                    <div class="city-selector-wrap w-full sm:w-auto relative">
                        <i class="bi bi-geo-alt-fill absolute left-3.5 top-1/2 -translate-y-1/2 text-primary-600 text-sm"></i>
                        <select id="citySelect" aria-label="Pilih kota jadwal sholat" class="w-full sm:w-64 pl-10 pr-10 py-2.5 text-xs font-bold text-stone-700 bg-stone-50 hover:bg-stone-100 border border-stone-200 rounded-xl outline-none cursor-pointer appearance-none transition-all duration-300 focus:bg-white focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                            @foreach ($cityOptions as $city)
                            <option value="{{ $city['id'] }}" {{ $city['id'] === $defaultCity['id'] ? 'selected' : '' }}>
                                {{ $city['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Refresher Button -->
                <button type="button" id="refreshPrayerButton" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 border-2 border-primary-600 text-primary-700 hover:bg-primary-600 hover:text-white text-xs font-extrabold uppercase tracking-wider rounded-xl transition duration-300">
                    <i class="bi bi-arrow-clockwise"></i> Segarkan Jadwal
                </button>
            </div>

        </div>
    </div>

    <!-- ===== JADWAL IMAM SHOLAT SECTION ===== -->
    @if(isset($jadwalImam) && count($jadwalImam) > 0)
    <section class="mt-16 scroll-reveal" id="jadwal-imam">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-6 border-b border-stone-200">
            <div class="space-y-1">
                <div class="section-kicker text-amber-700 font-extrabold uppercase tracking-widest text-xs flex items-center gap-1.5">
                    <i class="bi bi-person-fill-check text-sm"></i> Pelayanan Ibadah Rawatib
                </div>
                <h2 class="font-display text-3xl font-extrabold tracking-tight text-stone-850">Jadwal Imam Sholat</h2>
            </div>
            <p class="text-stone-500 text-sm max-w-md leading-relaxed">
                Daftar ustadz dan kyai yang bertugas menjadi imam sholat fardhu berjamaah di Masjid Agung Al-Musabaqoh Subang.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($jadwalImam as $dateString => $schedules)
            <div class="bg-white border border-stone-150 rounded-3xl p-6 shadow-md hover:shadow-xl transition-all duration-300 relative overflow-hidden group">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-600 to-amber-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                
                <h3 class="font-display text-base font-black text-emerald-950 flex items-center gap-2 mb-4 border-b border-stone-100 pb-3">
                    <i class="bi bi-calendar3 text-amber-600"></i>
                    {{ $dateString }}
                </h3>

                <div class="space-y-3">
                    @foreach($schedules as $schedule)
                    <div class="flex items-center justify-between bg-stone-50 hover:bg-stone-100/70 p-3.5 rounded-2xl border border-stone-150/40 transition-all duration-200">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center px-3 py-1 bg-emerald-50 text-emerald-800 text-[10px] font-black uppercase tracking-wider rounded-lg border border-emerald-100">
                                {{ $schedule->waktu_sholat }}
                            </span>
                        </div>
                        <div class="text-right">
                            <strong class="block text-sm text-stone-850 font-bold leading-tight">{{ $schedule->imam?->nama ?? 'Ust. Fulan' }}</strong>
                            <span class="text-[9px] text-stone-400 font-bold uppercase tracking-wider block mt-0.5">
                                Imam {{ $schedule->imam?->status ?? 'Masyarakat' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <section class="overview-strip scroll-reveal mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
        $statIcons = [
        'kegiatan' => 'bi-calendar-week-fill',
        'agenda' => 'bi-calendar-week-fill',
        'kas' => 'bi-wallet-fill',
        'keuangan' => 'bi-wallet-fill',
        'donasi' => 'bi-heart-fill',
        'zakat' => 'bi-box2-heart-fill',
        ];
        @endphp
        @foreach ($overviewStats as $item)
        @php
        $iconClass = 'bi-arrow-right-circle-fill';
        $lowerLabel = strtolower($item['label']);
        foreach ($statIcons as $key => $icon) {
        if (str_contains($lowerLabel, $key)) {
        $iconClass = $icon;
        break;
        }
        }
        @endphp
        <article class="bg-white border border-stone-150 rounded-2xl p-6 flex items-center justify-between shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <!-- Bottom Colored Accent Bar on hover -->
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-600 to-amber-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>

            <div class="space-y-1">
                <span class="block text-[11px] font-bold text-stone-400 uppercase tracking-widest">{{ $item['label'] }}</span>
                <strong class="block font-display text-2xl md:text-3xl font-black text-stone-850">{{ $item['value'] }}</strong>
            </div>
            <div class="w-14 h-14 rounded-xl bg-stone-50 group-hover:bg-primary-50 text-primary-600 group-hover:text-primary-700 flex items-center justify-center text-2xl transition-all duration-300">
                <i class="bi {{ $iconClass }}"></i>
            </div>
        </article>
        @endforeach
    </section>

    <!-- Latest News Section (Berita) -->
    <section class="latest-news scroll-reveal mt-20" id="berita">
        <div class="latest-news-header flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-6 border-b border-stone-200">
            <div class="space-y-1">
                <div class="section-kicker text-amber-700 font-extrabold uppercase tracking-widest text-xs flex items-center gap-1.5">
                    <i class="bi bi-journal-text text-sm"></i> Kabar Masjid Agung
                </div>
                <h2 class="font-display text-3xl font-extrabold tracking-tight text-stone-850">Berita Masjid Terkini</h2>
            </div>
            <p class="text-stone-500 text-sm max-w-md leading-relaxed">
                Ikuti perkembangan terbaru mengenai renovasi fasilitas, dokumentasi kajian keislaman, serta pengumuman hari besar di lingkungan DKM.
            </p>
        </div>

        <div class="latest-news-grid grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            @forelse ($beritaTerbaru as $item)
            <article class="bg-white border border-stone-200/60 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 flex flex-col group">

                <!-- Media cover -->
                <div class="relative aspect-video overflow-hidden bg-stone-100">
                    <img
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : $heroImage }}"
                        alt="{{ $item->judul }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                <!-- Card Body -->
                <div class="p-5 flex flex-col flex-1 space-y-3">
                    <h3 class="font-display text-base font-extrabold text-stone-850 group-hover:text-primary-700 transition duration-300 line-clamp-2 leading-snug">
                        {{ $item->judul }}
                    </h3>

                    <!-- Metadata with Icons -->
                    <div class="flex items-center gap-3 text-[11px] font-bold text-stone-400 uppercase tracking-wider">
                        <span class="inline-flex items-center gap-1"><i class="bi bi-calendar3 text-primary-600"></i> {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</span>
                        <span class="inline-flex items-center gap-1"><i class="bi bi-person-circle text-primary-600"></i> {{ $item->penulis }}</span>
                    </div>

                    <p class="text-stone-500 text-xs md:text-sm leading-relaxed line-clamp-3">
                        {{ $item->sinopsis ? \Illuminate\Support\Str::limit(strip_tags($item->sinopsis), 150) : \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 150) }}
                    </p>

                    <a href="{{ route('frontend.berita.show', $item->id) }}" class="inline-flex items-center gap-1 text-primary-700 group-hover:text-amber-600 font-display text-xs font-black uppercase tracking-wider pt-2 self-start border-b-2 border-transparent hover:border-amber-500 transition duration-300 mt-auto">
                        Selengkapnya <i class="bi bi-arrow-right-short text-base transition-transform duration-300 group-hover:translate-x-1"></i>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-3 bg-white border-2 border-dashed border-stone-250 rounded-2xl py-12 px-6 text-center text-stone-400">
                <i class="bi bi-inbox text-5xl text-stone-200 block mb-3"></i>
                <p class="font-semibold text-sm">Belum ada berita yang dipublikasikan saat ini.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            <a href="{{ route('frontend.berita') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-700 to-primary-600 hover:from-primary-800 hover:to-primary-700 text-white text-sm md:text-base font-extrabold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="bi bi-newspaper text-lg"></i> Lihat Semua Berita <i class="bi bi-arrow-right-short text-lg"></i>
            </a>
        </div>
    </section>

    <!-- Detailed Sections Container -->
    <div class="grid grid-cols-1 gap-12 mt-20">

        <!-- Kegiatan Section -->
        <section class="bg-white border border-stone-150 rounded-3xl p-6 md:p-8 shadow-lg scroll-reveal relative overflow-hidden" id="kegiatan">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-primary-600"></div>
            <div class="space-y-4">
                <div class="inline-flex items-center gap-1.5 bg-primary-50 px-3.5 py-1.5 rounded-full text-xs font-bold text-primary-700 uppercase tracking-wider">
                    <i class="bi bi-calendar-check"></i> Agenda Kegiatan
                </div>
                <h2 class="font-display text-2xl md:text-3xl font-extrabold tracking-tight text-stone-850">Jadwal & Agenda Kemakmuran Masjid</h2>
                <p class="text-stone-500 text-sm max-w-3xl leading-relaxed">
                    Jadwal kajian rutin mingguan, tabligh akbar, santunan sosial, serta rapat pengurus DKM yang diselenggarakan demi mempererat silaturahmi jamaah.
                </p>

                @if($nextEvent)
                <div class="bg-gradient-to-r from-emerald-950 to-emerald-900 text-white rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6 border border-emerald-800 shadow-md mt-4" data-aos="fade-up">
                    <div class="space-y-2">
                        <span class="inline-flex items-center gap-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider">
                            <i class="bi bi-clock-fill"></i> Kegiatan Mendatang
                        </span>
                        <h3 class="text-xl font-extrabold font-display text-white leading-snug">{{ $nextEvent['title'] }}</h3>
                        <p class="text-sm text-emerald-100/80 flex flex-wrap gap-x-4 gap-y-1 pt-1 font-semibold">
                            <span class="flex items-center gap-1.5"><i class="bi bi-calendar3 text-amber-400"></i> {{ $nextEvent['date'] }}</span>
                            <span class="flex items-center gap-1.5"><i class="bi bi-clock text-amber-400"></i> {{ $nextEvent['waktu'] }}</span>
                            <span class="flex items-center gap-1.5"><i class="bi bi-geo-alt text-amber-400"></i> {{ $nextEvent['tempat'] }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 border border-white/10 px-5 py-4 rounded-xl backdrop-blur-sm shrink-0" id="eventCountdown" data-date="{{ $nextEvent['iso_date'] }} {{ $nextEvent['waktu'] }}">
                        <div class="text-center min-w-[50px]">
                            <span class="days block text-2xl font-black text-amber-400 leading-none">00</span>
                            <span class="text-[9px] text-emerald-100/60 uppercase font-bold tracking-widest block mt-1">Hari</span>
                        </div>
                        <span class="text-white/30 text-xl font-bold">:</span>
                        <div class="text-center min-w-[50px]">
                            <span class="hours block text-2xl font-black text-amber-400 leading-none">00</span>
                            <span class="text-[9px] text-emerald-100/60 uppercase font-bold tracking-widest block mt-1">Jam</span>
                        </div>
                        <span class="text-white/30 text-xl font-bold">:</span>
                        <div class="text-center min-w-[50px]">
                            <span class="minutes block text-2xl font-black text-amber-400 leading-none">00</span>
                            <span class="text-[9px] text-emerald-100/60 uppercase font-bold tracking-widest block mt-1">Menit</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-2 flex justify-start">
                    <a href="{{ route('frontend.kegiatan') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-primary-700 hover:bg-primary-800 text-white text-sm font-extrabold shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="bi bi-calendar2-week"></i>
                        Lihat Agenda Kegiatan Selengkapnya
                        <i class="bi bi-arrow-right-short text-lg"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                    @forelse ($kegiatanCards as $item)
                    <div class="bg-stone-50 hover:bg-white border border-stone-150 rounded-2xl p-5 hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute top-4 right-4 w-10 h-10 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-lg">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div class="space-y-2 mt-2">
                            <span class="block text-[10px] font-bold text-primary-700 uppercase tracking-widest">{{ $item['title'] }}</span>
                            <b class="block font-display text-xl font-extrabold text-stone-850 group-hover:text-primary-700 transition duration-300">{{ $item['value'] }}</b>
                            <p class="text-stone-500 text-xs md:text-sm leading-relaxed pt-1">
                                {{ $item['content'] ?: 'Detail tanggal, waktu, atau penanggung jawab kegiatan belum dicantumkan.' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 bg-stone-50 border border-stone-150 rounded-2xl p-8 text-center text-stone-400">
                        <i class="bi bi-exclamation-circle text-4xl text-stone-300 block mb-2"></i>
                        <strong class="block font-display text-base font-bold text-stone-700">Belum Ada Agenda Terdekat</strong>
                        <span class="text-xs text-stone-500">Silakan kembali lagi nanti atau hubungi pengurus untuk informasi kegiatan.</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <div class="content-divider scroll-reveal" aria-hidden="true">
            <span></span>
        </div>

        <!-- Laporan Keuangan Section -->
        <section class="bg-white border border-stone-150 rounded-3xl p-6 md:p-8 shadow-lg scroll-reveal relative overflow-hidden" id="laporan">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
            <div class="space-y-4">
                <div class="inline-flex items-center gap-1.5 bg-blue-50 px-3.5 py-1.5 rounded-full text-xs font-bold text-blue-700 uppercase tracking-wider">
                    <i class="bi bi-shield-check"></i> Transparansi Kas
                </div>
                <h2 class="font-display text-2xl md:text-3xl font-extrabold tracking-tight text-stone-850">Laporan Keuangan & Kas Masjid Agung</h2>
                <p class="text-stone-500 text-sm max-w-3xl leading-relaxed">
                    Laporan pertanggungjawaban dana umat secara berkala yang mencakup kas masuk bulanan, pengeluaran operasional, serta saldo akhir.
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                    <!-- Cards -->
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-5">
                        @foreach ($laporanCards as $item)
                        @php
                        $isMasuk = str_contains(strtolower($item['title']), 'masuk');
                        $isKeluar = str_contains(strtolower($item['title']), 'keluar');
                        $accentColor = $isMasuk ? 'emerald' : ($isKeluar ? 'red' : 'blue');
                        @endphp
                        <div class="bg-stone-50 hover:bg-white border border-stone-150 rounded-2xl p-5 hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
                            <div class="absolute top-4 right-4 w-10 h-10 rounded-lg flex items-center justify-center text-lg {{ $accentColor === 'emerald' ? 'bg-emerald-50 text-emerald-600' : ($accentColor === 'red' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600') }}">
                                @if($accentColor === 'emerald')
                                <i class="bi bi-arrow-down-left-circle-fill"></i>
                                @elseif($accentColor === 'red')
                                <i class="bi bi-arrow-up-right-circle-fill"></i>
                                @else
                                <i class="bi bi-wallet2"></i>
                                @endif
                            </div>
                            <div class="space-y-2 mt-2">
                                <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest">{{ $item['title'] }}</span>
                                <b class="block font-display text-xl md:text-2xl font-extrabold {{ $accentColor === 'emerald' ? 'text-emerald-700' : ($accentColor === 'red' ? 'text-red-700' : 'text-blue-750') }}">{{ $item['value'] }}</b>
                                <p class="text-stone-500 text-xs md:text-sm leading-relaxed">
                                    {{ $item['content'] }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Sparkline Chart -->
                    <div class="bg-stone-50 rounded-2xl border border-stone-150 p-5 flex flex-col justify-between">
                        <div>
                            <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1.5">Tren Kas 6 Bulan Terakhir</span>
                            <div id="chart-sparkline" class="w-full"></div>
                        </div>
                        <div class="pt-3 border-t border-stone-200/50 flex justify-between items-center">
                            <span class="text-[10px] text-stone-400 font-bold uppercase tracking-wider">Tren Bulanan</span>
                            <a href="{{ route('frontend.laporan') }}" class="text-xs font-bold text-primary-700 hover:text-primary-800 flex items-center gap-1 transition-colors">
                                Detail Laporan <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Donasi Section -->
        <section class="bg-white border border-stone-150 rounded-3xl p-6 md:p-8 shadow-lg scroll-reveal relative overflow-hidden" id="donasi">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500"></div>
            <div class="space-y-4">
                <div class="inline-flex items-center gap-1.5 bg-amber-50 px-3.5 py-1.5 rounded-full text-xs font-bold text-amber-700 uppercase tracking-wider">
                    <i class="bi bi-gift-fill"></i> Ladang Amal Jariah
                </div>
                <h2 class="font-display text-2xl md:text-3xl font-extrabold tracking-tight text-stone-850">Kanal Partisipasi Infak, Sedekah & Zakat</h2>
                <p class="text-stone-500 text-sm max-w-3xl leading-relaxed">
                    Salurkan sebagian harta terbaik Anda secara mudah, aman, dan langsung ditujukan ke rekening kas pembangunan atau pemeliharaan Masjid Agung Subang.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                    @foreach ($donasiCards as $item)
                    <div class="bg-stone-50 hover:bg-white border border-stone-150 rounded-2xl p-5 hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute top-4 right-4 w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div class="space-y-2 mt-2">
                            <span class="block text-[10px] font-bold text-amber-800 uppercase tracking-widest">{{ $item['title'] }}</span>
                            <b class="block font-display text-xl md:text-2xl font-extrabold text-stone-850">{{ $item['value'] }}</b>
                            <p class="text-stone-500 text-xs md:text-sm leading-relaxed">
                                {{ $item['content'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Zakat Calculator Card -->
                <article class="bg-gradient-to-br from-amber-50 to-amber-100/50 border border-amber-200/60 rounded-3xl p-6 md:p-8 mt-8 shadow-sm">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-6 space-y-3">
                            <span class="inline-flex items-center gap-1.5 bg-amber-500/10 text-amber-800 border border-amber-500/25 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                                <i class="bi bi-calculator-fill text-amber-600"></i> Layanan Transparansi Zakat
                            </span>
                            <h3 class="font-display text-2xl font-black text-stone-850">Kalkulator Zakat Penghasilan</h3>
                            <p class="text-stone-600 text-sm leading-relaxed">
                                Hitung kewajiban Zakat Profesi / Penghasilan bulanan Anda dengan mudah berdasarkan ketentuan Nisab (setara 85 gram emas per tahun).
                            </p>
                        </div>
                        <div class="lg:col-span-6 bg-white rounded-2xl p-6 shadow-md border border-stone-100 space-y-4">
                            <div>
                                <label for="zakatInput" class="block text-xs font-bold uppercase text-stone-500 tracking-wider mb-2 font-bold">Pendapatan Bulanan (Rupiah)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 font-bold text-sm">Rp</span>
                                    <input type="number" id="zakatInput" placeholder="Masukkan nominal, misal: 10000000" class="w-full bg-stone-50 border border-stone-200 rounded-xl pl-10 pr-4 py-3 text-stone-800 font-extrabold outline-none focus:border-amber-500 focus:bg-white focus:ring-2 focus:ring-amber-500/10 transition">
                                </div>
                            </div>
                            <div class="flex items-center justify-between border-t border-stone-100 pt-4">
                                <div>
                                    <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest">Wajib Zakat (2.5%)</span>
                                    <strong id="zakatResult" class="block font-display text-2xl font-black text-amber-700">Rp 0</strong>
                                </div>
                                <a href="{{ route('frontend.donasi') }}" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-stone-950 font-bold text-sm px-5 py-3 rounded-xl shadow-sm hover:shadow transition-all">
                                    Salurkan Zakat
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

    </div>

    @endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const quotes = @json($quotes);
        const quickLinks = @json($quickLinks);
        const defaultCity = @json($defaultCity);

        const prayerState = {
            cityId: defaultCity.id,
            cityName: defaultCity.name,
            timerHandle: null,
            quoteHandle: null,
            todaySchedule: null,
        };

        const prayerLabels = [{
                key: 'subuh',
                label: 'Subuh'
            },
            {
                key: 'dzuhur',
                label: 'Dzuhur'
            },
            {
                key: 'ashar',
                label: 'Ashar'
            },
            {
                key: 'maghrib',
                label: 'Maghrib'
            },
            {
                key: 'isya',
                label: 'Isya'
            },
        ];

        const quoteTitle = document.getElementById('quoteTitle');
        const quoteText = document.getElementById('quoteText');
        const quoteSource = document.getElementById('quoteSource');
        const quoteDate = document.getElementById('quoteDate');
        const countdownBox = document.getElementById('countdownBox');
        const prayerTimes = document.getElementById('prayerTimes');
        const citySelect = document.getElementById('citySelect');
        const refreshPrayerButton = document.getElementById('refreshPrayerButton');
        const quickSearchForm = document.getElementById('quickSearchForm');
        const quickSearchInput = document.getElementById('quickSearchInput');

        function rotateQuotes() {
            let index = 0;

            const applyQuote = (quote) => {
                if (quoteTitle) quoteTitle.textContent = quote.title;
                quoteText.textContent = `"${quote.text}"`;
                quoteSource.textContent = `— ${quote.source}`;
                quoteDate.textContent = quote.date;
            };

            applyQuote(quotes[index]);

            if (prayerState.quoteHandle) {
                clearInterval(prayerState.quoteHandle);
            }

            prayerState.quoteHandle = setInterval(() => {
                index = (index + 1) % quotes.length;
                applyQuote(quotes[index]);
            }, 10000);
        }

        function toMinutes(timeString) {
            const [hours, minutes] = timeString.split(':').map(Number);
            return (hours * 60) + minutes;
        }

        function formatDateLabel(date) {
            return new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            }).format(date);
        }

        function getActivePrayerIndex(schedule, nowMinutes) {
            const times = prayerLabels.map((item) => toMinutes(schedule[item.key]));
            let activeIndex = -1;

            for (let index = times.length - 1; index >= 0; index -= 1) {
                if (nowMinutes >= times[index]) {
                    activeIndex = index;
                    break;
                }
            }

            return activeIndex;
        }

        function getNextPrayer(schedule, nowMinutes) {
            for (const item of prayerLabels) {
                const totalMinutes = toMinutes(schedule[item.key]);
                if (nowMinutes < totalMinutes) {
                    return {
                        key: item.key,
                        label: item.label,
                        totalMinutes,
                        time: schedule[item.key],
                    };
                }
            }

            return {
                key: prayerLabels[0].key,
                label: prayerLabels[0].label,
                totalMinutes: toMinutes(schedule[prayerLabels[0].key]) + (24 * 60),
                time: schedule[prayerLabels[0].key],
                tomorrow: true,
            };
        }

        function renderPrayerTimes(schedule) {
            const now = new Date();
            const nowMinutes = (now.getHours() * 60) + now.getMinutes();
            const activeIndex = getActivePrayerIndex(schedule, nowMinutes);

            prayerTimes.innerHTML = prayerLabels.map((item, index) => {
                const isActive = index === activeIndex;
                return `
                    <div class="flex flex-col items-center justify-between p-4 rounded-xl transition-all duration-300 ${
                        isActive
                            ? 'bg-gradient-to-br from-emerald-700 to-emerald-950 text-white shadow-lg shadow-emerald-950/20 scale-105 border-2 border-amber-500/35 relative before:content-[\'SEKARANG\'] before:absolute before:-top-2.5 before:left-1/2 before:-translate-x-1/2 before:text-[9px] before:font-black before:bg-amber-500 before:text-stone-950 before:px-2.5 before:py-0.5 before:rounded-full before:tracking-wider'
                            : 'bg-stone-50 text-stone-850 border border-stone-150 hover:bg-stone-100 hover:scale-[1.02]'
                    }">
                        <span class="text-[10px] font-bold uppercase tracking-widest ${isActive ? 'text-amber-300' : 'text-stone-400'} mb-1.5 mt-1.5">${item.label}</span>
                        <strong class="text-2xl md:text-3xl font-black font-display tracking-tight">${schedule[item.key]}</strong>
                    </div>
                `;
            }).join('');
        }

        function getHijriDate(date = new Date()) {
            try {
                const formatter = new Intl.DateTimeFormat('id-ID-u-ca-islamic-umalqura', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                return formatter.format(date).replace(/AH/g, 'H').trim();
            } catch (e) {
                return "1447 H";
            }
        }

        function renderCountdown(schedule, locationName, sourceDateLabel) {
            const now = new Date();
            const nowMinutes = (now.getHours() * 60) + now.getMinutes();
            const nextPrayer = getNextPrayer(schedule, nowMinutes);
            const nextPrayerDate = new Date();

            if (nextPrayer.tomorrow) {
                nextPrayerDate.setDate(nextPrayerDate.getDate() + 1);
            }

            const [targetHours, targetMinutes] = nextPrayer.time.split(':').map(Number);
            nextPrayerDate.setHours(targetHours, targetMinutes, 0, 0);

            const diff = Math.max(0, nextPrayerDate.getTime() - now.getTime());
            const totalSeconds = Math.floor(diff / 1000);
            const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const seconds = String(totalSeconds % 60).padStart(2, '0');

            const hijriDate = getHijriDate(now);

            countdownBox.querySelector('.countdown-main').innerHTML = `
                <div class="inline-flex items-center gap-1.5 bg-amber-500 text-stone-950 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider mb-2 animate-pulse">
                    <i class="bi bi-bell-fill"></i> Menuju Adzan ${nextPrayer.label}
                </div>
                <div class="flex gap-2.5 justify-start mb-4">
                    <div class="bg-white/10 border border-white/10 rounded-xl p-2.5 min-w-[65px] text-center backdrop-blur-md">
                        <strong class="text-2xl md:text-3xl font-black font-display text-amber-400 block leading-none">${hours}</strong>
                        <span class="text-[9px] font-bold text-emerald-100/60 uppercase tracking-widest block mt-1.5">Jam</span>
                    </div>
                    <div class="bg-white/10 border border-white/10 rounded-xl p-2.5 min-w-[65px] text-center backdrop-blur-md">
                        <strong class="text-2xl md:text-3xl font-black font-display text-amber-400 block leading-none">${minutes}</strong>
                        <span class="text-[9px] font-bold text-emerald-100/60 uppercase tracking-widest block mt-1.5">Menit</span>
                    </div>
                    <div class="bg-white/10 border border-white/10 rounded-xl p-2.5 min-w-[65px] text-center backdrop-blur-md">
                        <strong class="text-2xl md:text-3xl font-black font-display text-amber-400 block leading-none">${seconds}</strong>
                        <span class="text-[9px] font-bold text-emerald-100/60 uppercase tracking-widest block mt-1.5">Detik</span>
                    </div>
                </div>
                <div class="text-xs md:text-sm text-emerald-100/80 space-y-1.5 font-semibold">
                    <div class="flex items-center gap-2"><i class="bi bi-clock-history text-amber-400 text-sm"></i> Waktu Sholat : <strong class="text-white font-extrabold font-display ml-1">${nextPrayer.label} (${nextPrayer.time})</strong></div>
                    <div class="flex items-center gap-2"><i class="bi bi-geo-alt-fill text-amber-400 text-sm"></i> Lokasi : <strong class="text-white font-bold ml-1">${locationName}</strong></div>
                    <div class="flex items-center gap-2"><i class="bi bi-calendar-check-fill text-amber-400 text-sm"></i> Masehi : <strong class="text-white font-bold ml-1">${sourceDateLabel}</strong></div>
                    <div class="flex items-center gap-2"><i class="bi bi-moon-stars-fill text-amber-400 text-sm"></i> Hijriah : <strong class="text-white font-bold ml-1">${hijriDate}</strong></div>
                </div>
            `;
        }

        function startPrayerTimer(schedule, locationName, sourceDateLabel) {
            if (prayerState.timerHandle) {
                clearInterval(prayerState.timerHandle);
            }

            const refreshViews = () => {
                renderCountdown(schedule, locationName, sourceDateLabel);
                renderPrayerTimes(schedule);
            };

            refreshViews();
            prayerState.timerHandle = setInterval(refreshViews, 1000);
        }

        async function loadPrayerSchedule() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const url = `https://api.myquran.com/v2/sholat/jadwal/${prayerState.cityId}/${year}/${month}/${day}`;

            countdownBox.querySelector('.countdown-main').innerHTML = `
                <div class="flex items-center justify-center py-6 gap-2 text-stone-300 font-semibold">
                    <span class="w-5 h-5 border-2 border-amber-500 border-t-transparent rounded-full animate-spin"></span> Memuat waktu sholat...
                </div>
            `;
            prayerTimes.innerHTML = `
                <div class="col-span-5 bg-stone-50 py-6 text-center text-stone-400 font-semibold rounded-xl">
                    <span class="w-5 h-5 border-2 border-primary-500 border-t-transparent rounded-full animate-spin inline-block align-middle mr-2"></span> Menyiapkan waktu sholat...
                </div>
            `;

            try {
                const response = await fetch(url);
                const json = await response.json();

                if (!response.ok || !json.data || !json.data.jadwal) {
                    throw new Error('Respons API tidak valid.');
                }

                const payload = json.data;
                prayerState.todaySchedule = payload.jadwal;
                prayerState.cityName = payload.lokasi || citySelect.options[citySelect.selectedIndex].text;

                startPrayerTimer(payload.jadwal, prayerState.cityName, payload.jadwal.tanggal || formatDateLabel(now));
            } catch (error) {
                if (prayerState.timerHandle) {
                    clearInterval(prayerState.timerHandle);
                }

                countdownBox.querySelector('.countdown-main').innerHTML = `
                    <div class="bg-red-950/20 border border-red-500/30 text-red-300 rounded-xl p-4 text-xs font-semibold flex items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-amber-500 text-lg"></i> Gagal memuat jadwal sholat. Periksa koneksi internet Anda.
                    </div>
                `;
                prayerTimes.innerHTML = `
                    <div class="col-span-5 bg-red-50 text-red-700 py-4 text-center text-xs font-bold rounded-xl border border-red-100">
                        Data jadwal sholat tidak tersedia.
                    </div>
                `;
            }
        }

        // ─── Search Dropdown ──────────────────────────────────────────────────────
        const searchContainer = document.getElementById('searchContainer');
        const searchDropdown = document.getElementById('searchDropdown');
        const searchDropdownList = document.getElementById('searchDropdownList');
        const searchDropdownEmpty = document.getElementById('searchDropdownEmpty');

        /**
         * Extended menu catalogue for the live-suggestion dropdown.
         * Each entry maps display info to a section anchor.
         */
        const searchCatalogue = [{
                label: 'Beranda',
                icon: 'bi-house-door-fill',
                hint: 'Halaman utama portal',
                anchor: '#beranda'
            },
            {
                label: 'Jadwal Kegiatan',
                icon: 'bi-calendar-check-fill',
                hint: 'Agenda & jadwal kemakmuran masjid',
                anchor: '#kegiatan'
            },
            {
                label: 'Berita / Kabar',
                icon: 'bi-newspaper',
                hint: 'Berita dan kabar terkini masjid',
                anchor: '#berita'
            },
            {
                label: 'Laporan Keuangan',
                icon: 'bi-shield-check',
                hint: 'Transparansi kas & laporan keuangan',
                anchor: '#laporan'
            },
            {
                label: 'Donasi & Zakat',
                icon: 'bi-heart-fill',
                hint: 'Salurkan infak, sedekah, dan zakat',
                anchor: '#donasi'
            },
        ];

        /** Aliases that map user keywords to catalogue entries */
        const searchAliases = {
            'beranda': 0,
            'home': 0,
            'utama': 0,
            'kegiatan': 1,
            'agenda': 1,
            'jadwal': 1,
            'acara': 1,
            'berita': 2,
            'kabar': 2,
            'news': 2,
            'artikel': 2,
            'laporan': 3,
            'keuangan': 3,
            'kas': 3,
            'transparansi': 3,
            'donasi': 4,
            'zakat': 4,
            'infak': 4,
            'sedekah': 4,
            'sumbangan': 4,
        };

        function getSearchMatches(keyword) {
            if (!keyword) return [];
            const q = keyword.toLowerCase().trim();
            const matched = new Set();
            const results = [];

            // Exact / alias match first
            if (searchAliases[q] !== undefined) matched.add(searchAliases[q]);

            // Partial match on aliases
            Object.entries(searchAliases).forEach(([alias, idx]) => {
                if (alias.includes(q) || q.includes(alias)) matched.add(idx);
            });

            // Partial match on catalogue labels / hints
            searchCatalogue.forEach((item, idx) => {
                if (item.label.toLowerCase().includes(q) || item.hint.toLowerCase().includes(q)) matched.add(idx);
            });

            matched.forEach(idx => results.push(searchCatalogue[idx]));
            return results;
        }

        function renderSearchDropdown(keyword) {
            const matches = getSearchMatches(keyword);
            searchDropdownList.innerHTML = '';

            if (matches.length === 0) {
                searchDropdownList.classList.add('hidden');
                searchDropdownEmpty.classList.remove('hidden');
            } else {
                searchDropdownEmpty.classList.add('hidden');
                searchDropdownList.classList.remove('hidden');
                matches.forEach(item => {
                    const li = document.createElement('li');
                    li.setAttribute('role', 'option');
                    li.className = 'flex items-center gap-3 px-5 py-3.5 cursor-pointer hover:bg-white/10 transition-colors duration-150 group';
                    li.innerHTML = `
                        <span class="w-9 h-9 rounded-lg bg-amber-500/15 text-amber-400 flex items-center justify-center text-base shrink-0 group-hover:bg-amber-500/25 transition-colors">
                            <i class="bi ${item.icon}"></i>
                        </span>
                        <span class="flex flex-col min-w-0">
                            <strong class="text-sm font-bold text-white leading-snug">${item.label}</strong>
                            <span class="text-xs text-emerald-200/60 truncate">${item.hint}</span>
                        </span>
                        <i class="bi bi-arrow-right-short text-amber-400/60 text-xl ml-auto group-hover:text-amber-400 transition-colors"></i>
                    `;
                    li.addEventListener('click', () => {
                        quickSearchInput.value = '';
                        closeSearchDropdown();
                        const target = document.querySelector(item.anchor);
                        if (target) target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                    searchDropdownList.appendChild(li);
                });
            }

            searchDropdown.classList.remove('hidden');
        }

        function closeSearchDropdown() {
            searchDropdown.classList.add('hidden');
            searchDropdownList.innerHTML = '';
            searchDropdownEmpty.classList.add('hidden');
        }

        function handleQuickSearch(event) {
            event.preventDefault();
            closeSearchDropdown();

            const rawKeyword = quickSearchInput.value.trim().toLowerCase();
            if (!rawKeyword) {
                document.getElementById('beranda').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return;
            }

            // First try exact/alias match from quickLinks
            const target = quickLinks[rawKeyword];
            if (target) {
                const el = document.querySelector(target);
                if (el) {
                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    return;
                }
            }

            // Fall back to catalogue
            const matches = getSearchMatches(rawKeyword);
            if (matches.length > 0) {
                const el = document.querySelector(matches[0].anchor);
                if (el) {
                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    return;
                }
            }

            quickSearchInput.setCustomValidity('Kata kunci menu tidak ditemukan. Coba: beranda, kegiatan, berita, laporan, donasi.');
            quickSearchInput.reportValidity();
            setTimeout(() => quickSearchInput.setCustomValidity(''), 2000);
        }

        citySelect.addEventListener('change', () => {
            prayerState.cityId = citySelect.value;
            prayerState.cityName = citySelect.options[citySelect.selectedIndex].text;
            loadPrayerSchedule();
        });

        refreshPrayerButton.addEventListener('click', loadPrayerSchedule);
        quickSearchForm.addEventListener('submit', handleQuickSearch);

        // Live input listener → show/hide dropdown
        quickSearchInput.addEventListener('input', () => {
            quickSearchInput.setCustomValidity('');
            const val = quickSearchInput.value.trim();
            if (val.length === 0) {
                closeSearchDropdown();
                return;
            }
            renderSearchDropdown(val);
        });

        quickSearchInput.addEventListener('focus', () => {
            const val = quickSearchInput.value.trim();
            if (val.length > 0) renderSearchDropdown(val);
        });

        // Close dropdown when clicking outside the search container
        document.addEventListener('click', (e) => {
            if (searchContainer && !searchContainer.contains(e.target)) {
                closeSearchDropdown();
            }
        });

        // Close on Escape key
        quickSearchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSearchDropdown();
                quickSearchInput.blur();
            }
        });

        // Scroll Reveal Animation (IntersectionObserver API)
        const scrollRevealItems = document.querySelectorAll('.scroll-reveal');

        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -20px 0px',
            });

            scrollRevealItems.forEach((item, index) => {
                item.style.transitionDelay = `${Math.min(index * 60, 200)}ms`;
                revealObserver.observe(item);
            });
        } else {
            scrollRevealItems.forEach((item) => item.classList.add('is-visible'));
        }

        function startEventCountdown() {
            const el = document.getElementById('eventCountdown');
            if (!el) return;

            const targetDateStr = el.getAttribute('data-date');
            const datePart = targetDateStr.split(' ')[0];
            const timePart = targetDateStr.split(' ')[1] || '00:00';
            const timeOnly = timePart.split(' - ')[0] || '00:00';

            const targetDate = new Date(`${datePart.substring(0, 10)}T${timeOnly}:00`);

            const update = () => {
                const now = new Date();
                const diff = targetDate.getTime() - now.getTime();

                if (diff <= 0) {
                    el.innerHTML = `<div class="text-xs font-bold uppercase text-amber-400 tracking-wider">Kegiatan Sedang Berlangsung</div>`;
                    clearInterval(handle);
                    return;
                }

                const totalSec = Math.floor(diff / 1000);
                const d = Math.floor(totalSec / 86400);
                const h = Math.floor((totalSec % 86400) / 3600);
                const m = Math.floor((totalSec % 3600) / 60);

                el.querySelector('.days').textContent = String(d).padStart(2, '0');
                el.querySelector('.hours').textContent = String(h).padStart(2, '0');
                el.querySelector('.minutes').textContent = String(m).padStart(2, '0');
            };

            update();
            const handle = setInterval(update, 60000);
        }

        function initZakatCalculator() {
            const input = document.getElementById('zakatInput');
            const result = document.getElementById('zakatResult');
            if (!input || !result) return;

            input.addEventListener('input', function() {
                const val = parseFloat(input.value) || 0;
                const zakat = val * 0.025;
                result.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(zakat);
            });
        }

        function renderSparkline() {
            const sparklineData = @json($sparkline_data ?? []);
            if (sparklineData.length === 0) return;

            const labels = sparklineData.map(item => item.label);
            const pemasukan = sparklineData.map(item => item.pemasukan);
            const pengeluaran = sparklineData.map(item => item.pengeluaran);

            const options = {
                series: [{
                        name: 'Pemasukan',
                        data: pemasukan
                    },
                    {
                        name: 'Pengeluaran',
                        data: pengeluaran
                    }
                ],
                chart: {
                    type: 'area',
                    height: 140,
                    sparkline: {
                        enabled: true
                    },
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                },
                colors: ['#10b981', '#f97316'], // emerald and orange
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.01,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    x: {
                        show: true,
                        formatter: function(val, {
                            dataPointIndex
                        }) {
                            return sparklineData[dataPointIndex].label;
                        }
                    },
                    y: {
                        formatter: function(val) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#chart-sparkline"), options);
            chart.render();
        }

        rotateQuotes();
        loadPrayerSchedule();
        startEventCountdown();
        initZakatCalculator();
        renderSparkline();
    </script>
    @endpush