<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DKM Al-Musabaqoh Subang</title>
    @include('frontend._styles')
</head>
<body>
    @php
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

    <div class="page-shell">
        <section class="hero" id="beranda">
            <div class="topbar">
                <div class="brand">
                    <div class="brand-mark">
                        <img src="{{ asset('favicon.ico') }}" alt="Logo DKM Subang">
                    </div>
                    <div class="brand-copy"></div>
                </div>
                <nav class="nav" aria-label="Navigasi utama">
                    @foreach ($navItems as $index => $item)
                        <a href="{{ $item['href'] }}" class="{{ $index === 0 ? 'is-active' : '' }}">{{ $item['label'] }}</a>
                    @endforeach
                </nav>
            </div>

            <div class="hero-content reveal reveal-up">
                <div class="hero-left reveal reveal-left delay-1"></div>

                <div class="hero-right reveal reveal-right delay-2">
                    <div class="hero-eyebrow">Portal Informasi Majdi Agung Subang Al-Musabaqoh</div>
                    <h1>
                        Selamat Datang Di
                        <span>DKM Al-Musabaqoh Subang</span>
                    </h1>
                    <p>
                        Pusat informasi kegiatan, jadwal ibadah, berita masjid, laporan singkat, dan kanal donasi untuk jamaah.
                        Halaman ini menggunakan jadwal sholat dari API MyQuran dengan pola yang sama seperti modul admin.
                    </p>

                    <form class="search-bar" id="quickSearchForm">
                        <input
                            type="text"
                            id="quickSearchInput"
                            placeholder="Cari menu: berita, donasi, kegiatan..."
                            autocomplete="off"
                        >
                        <button type="submit">Cari</button>
                    </form>

                    <div class="hero-actions">
                        <a href="#kegiatan" class="hero-link hero-link-primary">Lihat Kegiatan</a>
                        <a href="#berita-terkini" class="hero-link hero-link-secondary">Berita Terkini</a>
                    </div>
                </div>
            </div>

        </section>

        <div class="prayer-panel-wrap reveal reveal-up delay-3">
            <div class="prayer-panel">
                <div class="panel-frame">
                    <div id="countdownBox" class="countdown-box">
                        <div class="moon-shape"></div>
                        <div class="countdown-main">
                            <div class="status-loading">Memuat jadwal sholat hari ini...</div>
                        </div>
                    </div>

                    <div class="quote-box">
                        <h3 id="quoteTitle">{{ $quotes[0]['title'] }}</h3>
                        <p id="quoteText">{{ $quotes[0]['text'] }}</p>
                        <small id="quoteSource">({{ $quotes[0]['source'] }})</small>
                        <div class="quote-date" id="quoteDate">{{ $quotes[0]['date'] }}</div>
                    </div>
                </div>

                <div id="prayerTimes" class="prayer-times">
                    <div class="status-loading">Menyiapkan waktu sholat...</div>
                </div>

                <div class="sholat-tools">
                    <div class="left">
                        <strong>Sumber: Kemenag RI via api.myquran.com</strong>
                        <select id="citySelect" aria-label="Pilih kota jadwal sholat">
                            @foreach ($cityOptions as $city)
                                <option value="{{ $city['id'] }}" {{ $city['id'] === $defaultCity['id'] ? 'selected' : '' }}>
                                    {{ $city['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" id="refreshPrayerButton">Muat Ulang Jadwal</button>
                </div>
            </div>
        </div>

        <section class="overview-strip scroll-reveal">
            @foreach ($overviewStats as $item)
                <article class="overview-card">
                    <span>{{ $item['label'] }}</span>
                    <strong>{{ $item['value'] }}</strong>
                </article>
            @endforeach
        </section>

        <section class="latest-news scroll-reveal" id="berita-terkini">
            <div class="section-anchor"></div>
            <div class="latest-news-header">
                <div>
                    <div class="section-kicker">Publikasi</div>
                    <h2>Berita Masjid Terkini</h2>
                </div>
                <p>Informasi terbaru yang telah dipublikasikan oleh admin masjid.</p>
            </div>

            <div class="latest-news-grid">
                @forelse ($beritaTerbaru as $item)
                    <article class="news-feature-card">
                        <div class="news-feature-media">
                            <img
                                src="{{ $item->gambar ? asset('storage/' . $item->gambar) : $heroImage }}"
                                alt="{{ $item->judul }}"
                            >
                        </div>
                        <div class="news-feature-body">
                            <h3>{{ $item->judul }}</h3>
                            <div class="news-feature-meta">
                                <span>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</span>
                                <span>{{ $item->penulis }}</span>
                            </div>
                            <p>{{ $item->sinopsis ? \Illuminate\Support\Str::limit(strip_tags($item->sinopsis), 190) : \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 190) }}</p>
                            <a href="#berita" class="news-feature-link">Selengkapnya</a>
                        </div>
                    </article>
                @empty
                    <div class="news-empty-state">
                        Belum ada berita yang dipublikasikan dari modul berita.
                    </div>
                @endforelse
            </div>
        </section>

        <div class="content-grid">
            <section class="content-card content-card-wide scroll-reveal" id="kegiatan">
                <div class="section-anchor"></div>
                <div class="section-kicker">Agenda</div>
                <h2>Kegiatan</h2>
                <p>
                    Menampilkan agenda dari modul jadwal kegiatan yang sudah dicatat di panel admin.
                </p>
                <div class="mini-stats">
                    @forelse ($kegiatanCards as $item)
                        <div class="mini-stat">
                            <strong>{{ $item['title'] }}</strong>
                            <b>{{ $item['value'] }}</b>
                            <span>{{ $item['content'] ?: 'Detail kegiatan belum diisi.' }}</span>
                        </div>
                    @empty
                        <div class="mini-stat">
                            <strong>Belum Ada Kegiatan</strong>
                            <b>-</b>
                            <span>Tambahkan data di modul jadwal kegiatan agar tampil di halaman depan.</span>
                        </div>
                    @endforelse
                </div>
            </section>

            <div class="content-divider scroll-reveal" aria-hidden="true">
                <span></span>
            </div>

            <section class="content-card content-card-wide scroll-reveal" id="laporan">
                <div class="section-anchor"></div>
                <div class="section-kicker">Transparansi</div>
                <h2>Laporan</h2>
                <div class="mini-stats">
                    @foreach ($laporanCards as $item)
                        <div class="mini-stat">
                            <strong>{{ $item['title'] }}</strong>
                            <b>{{ $item['value'] }}</b>
                            <span>{{ $item['content'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="content-card content-card-wide scroll-reveal" id="donasi">
                <div class="section-anchor"></div>
                <div class="section-kicker">Partisipasi</div>
                <h2>Donasi</h2>
                <div class="mini-stats">
                    @foreach ($donasiCards as $item)
                        <div class="mini-stat">
                            <strong>{{ $item['title'] }}</strong>
                            <b>{{ $item['value'] }}</b>
                            <span>{{ $item['content'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

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

        const prayerLabels = [
            { key: 'subuh', label: 'Subuh' },
            { key: 'dzuhur', label: 'Dzuhur' },
            { key: 'ashar', label: 'Ashar' },
            { key: 'maghrib', label: 'Maghrib' },
            { key: 'isya', label: 'Isya' },
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
                quoteTitle.textContent = quote.title;
                quoteText.textContent = quote.text;
                quoteSource.textContent = `(${quote.source})`;
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

            prayerTimes.innerHTML = prayerLabels.map((item, index) => `
                <div class="prayer-time ${index === activeIndex ? 'active' : ''}">
                    <span class="label">${item.label}</span>
                    <strong>${schedule[item.key]}</strong>
                </div>
            `).join('');
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
                <div class="timer-grid">
                    <div class="timer-segment">
                        <strong>${hours}</strong>
                        <span>Jam</span>
                    </div>
                    <div class="timer-segment">
                        <strong>${minutes}</strong>
                        <span>Menit</span>
                    </div>
                    <div class="timer-segment">
                        <strong>${seconds}</strong>
                        <span>Detik</span>
                    </div>
                </div>
                <div class="countdown-meta">
                    <div>Menuju waktu <strong>${nextPrayer.label}</strong></div>
                    <div>Lokasi : <strong>${locationName}</strong></div>
                    <div>Tanggal : <strong>${sourceDateLabel}</strong></div>
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

            countdownBox.querySelector('.countdown-main').innerHTML = '<div class="status-loading">Memuat jadwal sholat hari ini...</div>';
            prayerTimes.innerHTML = '<div class="status-loading">Menyiapkan waktu sholat...</div>';

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

                countdownBox.querySelector('.countdown-main').innerHTML = '<div class="status-error">Gagal memuat jadwal sholat. Periksa koneksi internet.</div>';
                prayerTimes.innerHTML = '<div class="status-error">Data waktu sholat tidak tersedia.</div>';
            }
        }

        function handleQuickSearch(event) {
            event.preventDefault();

            const rawKeyword = quickSearchInput.value.trim().toLowerCase();
            if (!rawKeyword) {
                document.getElementById('beranda').scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            const target = quickLinks[rawKeyword];
            if (target) {
                document.querySelector(target).scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }

            quickSearchInput.setCustomValidity('Menu tidak ditemukan. Gunakan: profil, kegiatan, berita, laporan, atau donasi.');
            quickSearchInput.reportValidity();
            setTimeout(() => quickSearchInput.setCustomValidity(''), 1500);
        }

        citySelect.addEventListener('change', () => {
            prayerState.cityId = citySelect.value;
            prayerState.cityName = citySelect.options[citySelect.selectedIndex].text;
            loadPrayerSchedule();
        });

        refreshPrayerButton.addEventListener('click', loadPrayerSchedule);
        quickSearchForm.addEventListener('submit', handleQuickSearch);
        quickSearchInput.addEventListener('input', () => quickSearchInput.setCustomValidity(''));

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
                threshold: 0.14,
                rootMargin: '0px 0px -40px 0px',
            });

            scrollRevealItems.forEach((item, index) => {
                item.style.transitionDelay = `${Math.min(index * 70, 240)}ms`;
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

