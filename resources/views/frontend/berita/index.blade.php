@extends('layouts.frontend')

@section('title', 'Berita Masjid - DKM Al-Musabaqoh')

@section('content')
    @php
        $beritaItems = collect($berita ?? []);
    @endphp

    <x-hero-banner
        badge="Berita & Artikel"
        title="Berita"
        accent="Masjid Al-Musabaqoh"
        subtitle="Informasi kegiatan masjid yang tertata, mudah dibaca, dan nyaman diikuti oleh seluruh jamaah."
        :bg-image="asset('storage/icon/FOTO.jpeg')"
        icon="bi-newspaper"
        badge-icon="bi-journal-text"
        cta-label="Lihat Berita Terbaru"
        cta-href="#berita-list"
    />

    <section class="page-section" id="berita-list" data-aos="fade-up" data-aos-delay="80">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($beritaItems as $index => $item)
                @php
                    $tanggal = \Illuminate\Support\Carbon::parse($item['tanggal'] ?? ($item->tanggal ?? now()))->translatedFormat('d M Y');
                    $thumb = $item['thumbnail'] ?? ($item->gambar ?? ($item->thumbnail ?? asset('storage/icon/foto.jpeg')));
                    $judul = $item['judul'] ?? ($item->judul ?? '');
                    $excerpt = $item['excerpt'] ?? ($item->sinopsis ?? ($item->isi_berita ?? ''));
                    $url = $item['url'] ?? ($item->url ?? route('frontend.berita.show', $item['id'] ?? $item->id ?? '#'));
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
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center">
                    <p class="text-lg font-bold text-stone-700">Belum ada berita yang dipublikasikan.</p>
                    <p class="mt-2 text-base text-stone-500">Silakan kembali lagi setelah admin menambahkan konten berita.</p>
                </div>
            @endforelse
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
@endsection
