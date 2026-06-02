<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DKM Al-Musabaqoh Subang - Portal Resmi Pelayanan Jamaah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        accent: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            950: '#451a03',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Segoe UI', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Fine-Tuning Styles for Perfect UI/UX */
        .islamic-pattern {
            background-color: #064e3b;
            background-image: radial-gradient(rgba(217, 119, 6, 0.15) 1px, transparent 0), radial-gradient(rgba(217, 119, 6, 0.15) 1px, transparent 0);
            background-size: 24px 24px;
            background-position: 0 0, 12px 12px;
        }

        .blob-shape {
            animation: morphing 8s ease-in-out infinite alternate;
        }

        @keyframes morphing {
            0% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            }

            100% {
                border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%;
            }
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 800ms cubic-bezier(0.16, 1, 0.3, 1), transform 800ms cubic-bezier(0.16, 1, 0.3, 1);
        }

        .scroll-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-[#faf9f6] text-stone-900 font-sans antialiased overflow-x-hidden">
    @php
    $navItems = [
    ['label' => 'Beranda', 'href' => route('frontend.home'), 'active' => true],
    ['label' => 'Profil Masjid', 'href' => route('frontend.profil'), 'active' => false],
    ['label' => 'Kegiatan', 'href' => route('frontend.kegiatan'), 'active' => false],
    ['label' => 'Berita', 'href' => route('frontend.berita'), 'active' => false],
    ['label' => 'Galeri', 'href' => route('frontend.galeri'), 'active' => false],
    ['label' => 'Laporan', 'href' => route('frontend.laporan'), 'active' => false],
    ];

    $quickLinks = [
    'beranda' => '#beranda',
    'home' => '#beranda',
    'kegiatan' => '#kegiatan',
    'agenda' => '#kegiatan',
    'berita' => '#berita',
    'laporan' => '#laporan',
    'donasi' => '#donasi',
    'zakat' => '#donasi',
    ];
    @endphp

    <!-- Page Shell Wrap -->
    <div class="w-full flex flex-col min-h-screen">
        @include('frontend.partials.navbar', ['navItems' => $navItems])

        <!-- Hero Section (Welcome & Search Banner) -->
        <section class="relative min-h-[85vh] flex flex-col justify-center islamic-pattern text-white pt-10 pb-28 md:pb-40 px-4" id="beranda" style="background-image: linear-gradient(rgba(6,78,59,0.88), rgba(6,78,59,0.92)), url('{{ asset('storage/icon/FOTO.jpeg') }}'); background-size: cover; background-position: center;">

            <!-- Floating Decorative Crescent Moon BG -->
            <div class="absolute top-10 right-10 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">

                <!-- Left Decorative Graphic (Visible on Desktop) -->
                <div class="hidden lg:flex lg:col-span-4 justify-center reveal reveal-left delay-1">
                    <div class="w-80 h-80 bg-gradient-to-br from-amber-400 to-amber-600 flex flex-col items-center justify-center text-white shadow-2xl relative blob-shape border-4 border-white/15">
                        <div class="absolute inset-0 bg-black/10 blob-shape"></div>
                        <i class="bi bi-mosque text-8xl drop-shadow-2xl relative z-10"></i>
                        <span class="font-display text-xl font-black uppercase tracking-widest mt-4 relative z-10 drop-shadow">BAITULLAH</span>
                    </div>
                </div>

                <!-- Right Welcome Content -->
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

                    <!-- Interactive Quick Search Bar -->
                    <form class="flex flex-col sm:flex-row gap-3 w-full max-w-xl bg-white/5 border border-white/15 p-2 rounded-2xl backdrop-blur-xl shadow-xl focus-within:border-amber-400/50 transition-all duration-300" id="quickSearchForm">
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

                    <!-- Quick Navigation Actions -->
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="#kegiatan" class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-amber-100 text-emerald-950 text-sm font-extrabold rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5">
                            <i class="bi bi-calendar-check-fill text-amber-600"></i> Jadwal Kegiatan
                        </a>
                        <a href="#berita-terkini" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-900/50 hover:bg-emerald-900/80 border border-emerald-800 text-white text-sm font-extrabold rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5">
                            <i class="bi bi-newspaper"></i> Kabar Masjid
                        </a>
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

            <!-- Overview Statistics Section -->
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

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
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
                    </div>
                </section>

            </div>

        </main>

        @include('frontend.partials.footer')

    </div>

    <!-- Script Bindings & Logic (100% Preserved) -->
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

            countdownBox.querySelector('.countdown-main').innerHTML = `
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
                    <div class="flex items-center gap-2"><i class="bi bi-clock-history text-amber-400 text-sm"></i> Menuju waktu <strong class="text-white font-extrabold font-display ml-1">${nextPrayer.label}</strong></div>
                    <div class="flex items-center gap-2"><i class="bi bi-geo-alt-fill text-amber-400 text-sm"></i> Lokasi : <strong class="text-white font-bold ml-1">${locationName}</strong></div>
                    <div class="flex items-center gap-2"><i class="bi bi-calendar-check-fill text-amber-400 text-sm"></i> Tanggal : <strong class="text-white font-bold ml-1">${sourceDateLabel}</strong></div>
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

        function handleQuickSearch(event) {
            event.preventDefault();

            const rawKeyword = quickSearchInput.value.trim().toLowerCase();
            if (!rawKeyword) {
                document.getElementById('beranda').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return;
            }

            const target = quickLinks[rawKeyword];
            if (target) {
                document.querySelector(target).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return;
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
        quickSearchInput.addEventListener('input', () => quickSearchInput.setCustomValidity(''));

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

        rotateQuotes();
        loadPrayerSchedule();
    </script>
</body>

</html>
