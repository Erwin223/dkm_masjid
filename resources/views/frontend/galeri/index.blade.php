@extends('layouts.frontend')

@section('title', 'Galeri Kegiatan - DKM Al-Musabaqoh')

@section('content')
    @php
        $galeriItems = collect($galeri ?? []);
    @endphp

    <x-hero-banner
        badge="Galeri Kegiatan"
        title="Galeri"
        accent="Masjid Al-Musabaqoh"
        subtitle="Foto-foto kegiatan ditampilkan dengan tampilan yang rapi agar mudah dibaca dan nyaman saat dibuka di ponsel maupun desktop."
        :bg-image="asset('storage/icon/foto.webp')"
        icon="bi-images"
        badge-icon="bi-images"
        cta-label="Lihat Galeri Lengkap"
        cta-href="#galeri-list"
    />

    <section class="page-section" id="galeri-list" data-aos="fade-up" data-aos-delay="80">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($galeriItems as $index => $item)
                @php
                    $tanggal = \Illuminate\Support\Carbon::parse($item['tanggal'] ?? ($item->tanggal ?? now()))->translatedFormat('d M Y');
                    $thumb = $item['thumbnail'] ?? ($item->gambar ?? asset('storage/icon/foto.webp'));
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
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-stone-300 bg-white px-6 py-16 text-center">
                    <p class="text-lg font-bold text-stone-700">Belum ada data galeri.</p>
                    <p class="mt-2 text-base text-stone-500">Silakan unggah dokumentasi kegiatan terlebih dahulu dari panel admin.</p>
                </div>
            @endforelse
        </div>

        @if(isset($galeriPaginated) && method_exists($galeriPaginated, 'hasPages') && $galeriPaginated->hasPages())
            <div class="mt-10 flex flex-col items-center gap-4 border-t border-stone-200 pt-8" data-aos="fade-up" data-aos-delay="120">
                <p class="text-sm font-semibold text-stone-600">
                    Menampilkan {{ $galeriPaginated->firstItem() }}-{{ $galeriPaginated->lastItem() }} dari {{ $galeriPaginated->total() }} galeri
                </p>
                <div class="pagination-wrapper">
                    {{ $galeriPaginated->links() }}
                </div>
            </div>
        @endif
    </section>
@endsection
