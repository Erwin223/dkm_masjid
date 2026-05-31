<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Masjid - DKM Al-Musabaqoh</title>
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

        // Prefer data passed from controller: $berita (collection of Berita models)
        $beritaItems = collect($berita ?? [])->whenEmpty(function () {
            return collect([
                [
                    'tanggal' => '2026-05-12',
                    'judul' => 'Kajian Rutin Malam Jumat Kembali Digelar',
                    'excerpt' => 'Pengurus mengundang jamaah untuk mengikuti kajian rutin malam Jumat yang disusun agar mudah diikuti oleh bapak-bapak dan keluarga.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=1200&q=80',
                    'url' => '#',
                ],
                [
                    'tanggal' => '2026-05-08',
                    'judul' => 'Program Bersih-Bersih Masjid Bersama Jamaah',
                    'excerpt' => 'Kegiatan gotong royong difokuskan pada kebersihan area utama, tempat wudhu, dan halaman agar jamaah lebih nyaman beribadah.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80',
                    'url' => '#',
                ],
                [
                    'tanggal' => '2026-05-01',
                    'judul' => 'Laporan Santunan dan Penyaluran Infak Bulanan',
                    'excerpt' => 'Pencatatan donasi dan penyaluran bantuan dilakukan lebih rapi agar jamaah dapat mengikuti perkembangan kegiatan sosial masjid.',
                    'thumbnail' => 'https://images.unsplash.com/photo-1524726240783-939bfdd63372?auto=format&fit=crop&w=1200&q=80',
                    'url' => '#',
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
                        <p class="hero-badge">Berita & Artikel</p>
                        <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl">
                            Informasi kegiatan masjid yang tertata dan mudah diikuti
                        </h1>
                        <p class="mt-5 text-base leading-8 text-emerald-50/85 sm:text-lg">
                            Setiap berita ditampilkan dalam kartu yang jelas agar jamaah dapat langsung melihat tanggal, judul, dan ringkasan isi berita.
                        </p>
                    </div>
                </div>
            </section>

            <section class="page-section" data-aos="fade-up" data-aos-delay="80">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($beritaItems as $index => $item)
                        @php
                            $tanggal = \Illuminate\Support\Carbon::parse($item['tanggal'] ?? ($item->tanggal ?? now()))->translatedFormat('d M Y');
                            $thumb = $item['thumbnail'] ?? ($item->gambar ?? ($item->thumbnail ?? asset('storage/icon/foto.jpeg')));
                            $judul = $item['judul'] ?? ($item->judul ?? ($item->judul ?? ''));
                            $excerpt = $item['excerpt'] ?? ($item->sinopsis ?? ($item->isi_berita ?? ''));
                            $url = $item['url'] ?? ($item->url ?? '#');
                        @endphp

                        <article class="surface-card surface-card-soft overflow-hidden" data-aos="zoom-in" data-aos-delay="{{ 60 * ($index % 6) }}">
                            <div class="group relative aspect-[16/10] overflow-hidden bg-stone-100">
                                <img src="{{ $thumb }}" alt="{{ $judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/60 via-transparent to-transparent"></div>
                                <div class="absolute inset-x-0 bottom-0 p-5">
                                    <time class="inline-flex rounded-full bg-white/95 px-3 py-1 text-[12px] font-black uppercase tracking-[0.22em] text-emerald-900">{{ $tanggal }}</time>
                                </div>
                            </div>
                            <div class="flex h-full flex-col p-6">
                                <h2 class="text-xl md:text-2xl font-black leading-snug tracking-tight text-stone-900">{{ $judul }}</h2>
                                <p class="mt-4 text-lg leading-7 text-stone-700">{{ \Illuminate\Support\Str::limit(strip_tags($excerpt), 180) }}</p>
                                <div class="mt-6">
                                    <a href="{{ $url }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-900 px-5 py-3 text-sm md:text-base font-bold text-white transition hover:bg-emerald-800">
                                        Baca Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($beritaPaginated->hasPages())
                    <div class="mt-12 flex justify-center">
                        <nav class="flex items-center gap-2">
                            <!-- Previous Page Link -->
                            @if ($beritaPaginated->onFirstPage())
                                <span class="px-4 py-2 text-stone-400 border border-stone-200 rounded-lg cursor-not-allowed">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $beritaPaginated->previousPageUrl() }}" class="px-4 py-2 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-50 transition">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            @endif

                            <!-- Page Numbers -->
                            @foreach ($beritaPaginated->getUrlRange(1, $beritaPaginated->lastPage()) as $page => $url)
                                @if ($page == $beritaPaginated->currentPage())
                                    <span class="px-4 py-2 bg-emerald-700 text-white rounded-lg font-bold">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-4 py-2 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-50 transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($beritaPaginated->hasMorePages())
                                <a href="{{ $beritaPaginated->nextPageUrl() }}" class="px-4 py-2 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-50 transition">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            @else
                                <span class="px-4 py-2 text-stone-400 border border-stone-200 rounded-lg cursor-not-allowed">
                                    <i class="bi bi-chevron-right"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
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
