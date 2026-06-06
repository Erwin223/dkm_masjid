@extends('layouts.frontend')

@section('title', $berita->judul . ' - DKM Al-Musabaqoh Subang')

@push('styles')
    <style>
        /* Enhanced Typography untuk Keterbacaan Senior-Friendly */
        .article-content {
            font-size: 1.125rem;
            line-height: 1.9;
            letter-spacing: 0.3px;
        }

        .article-content p {
            margin-bottom: 1.75rem;
        }

        .article-content h2,
        .article-content h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-family: "Outfit", sans-serif;
        }

        .article-content ul,
        .article-content ol {
            margin: 1.5rem 0;
            padding-left: 2.5rem;
        }

        .article-content li {
            margin-bottom: 0.75rem;
            line-height: 1.8;
        }

        .article-content strong,
        .article-content b {
            color: var(--primary);
            font-weight: 700;
        }

        .article-content em,
        .article-content i {
            color: var(--text-muted);
        }

        /* Kontras Tinggi untuk Readability */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            background-color: white;
            color: var(--primary);
            font-weight: 600;
            font-size: 1rem;
            border: 2px solid var(--primary);
            border-radius: var(--radius-lg);
            transition: var(--transition-smooth);
        }

        .back-button:hover {
            background-color: var(--primary);
            color: white;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--primary);
            font-weight: 600;
            transition: var(--transition-smooth);
        }

        .breadcrumb a:hover {
            color: var(--primary-light);
        }

        /* Article Header Styling */
        .article-header {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            font-size: 1rem;
        }

        .article-meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-muted);
        }

        .article-meta-item i {
            color: var(--accent);
            font-size: 1.25rem;
        }

        .article-meta-item strong {
            color: var(--text-main);
            font-weight: 600;
        }

        /* Hero Image Enhancement */
        .article-hero-image {
            width: 100%;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            display: block;
        }

        .article-hero-image img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        /* Related Articles Grid */
        .related-articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .related-article-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: var(--shadow-md);
        }

        .related-article-card:hover {
            box-shadow: var(--shadow-xl);
            transform: translateY(-4px);
        }

        .related-article-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-glow), var(--accent-glow));
        }

        .related-article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .related-article-card:hover .related-article-image img {
            transform: scale(1.08);
        }

        .related-article-content {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .related-article-date {
            display: inline-block;
            background: var(--accent-light);
            color: var(--accent-dark);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
            width: fit-content;
        }

        .related-article-title {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.4;
            color: var(--text-main);
            margin-bottom: 0.75rem;
            font-family: "Outfit", sans-serif;
        }

        .related-article-excerpt {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex: 1;
        }

        .related-article-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition-smooth);
        }

        .related-article-link:hover {
            gap: 0.75rem;
            color: var(--primary-light);
        }

        /* Divider Enhancement */
        .section-divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: var(--radius-full);
            margin: 0 0 1rem 0;
        }

        /* Call-to-Action Enhancement */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            color: white;
            text-align: center;
        }

        .cta-section h3 {
            color: white;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .cta-section p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background-color: white;
            color: var(--primary);
            padding: 1rem 2rem;
            border-radius: var(--radius-lg);
            font-weight: 700;
            transition: var(--transition-smooth);
        }

        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
    </style>
@endpush

@section('content')
    <!-- Top Navigation: Back Button & Breadcrumb -->
    <section class="bg-white border-b border-stone-200 sticky top-0 z-40">
        <div class="page-shell py-4">
            <div class="flex items-center justify-between" data-aos="fade-in" data-aos-duration="600">
                <!-- Back Button -->
                <a href="{{ route('frontend.berita') }}" class="back-button">
                    <i class="bi bi-chevron-left text-xl"></i>
                    <span>Kembali ke Halaman Berita</span>
                </a>

                <!-- Breadcrumb -->
                <nav class="breadcrumb hidden md:flex">
                    <a href="{{ route('frontend.home') }}">
                        <i class="bi bi-house-fill"></i> Beranda
                    </a>
                    <span class="text-stone-400">/</span>
                    <a href="{{ route('frontend.berita') }}">Berita</a>
                    <span class="text-stone-400">/</span>
                    <span class="text-stone-600">{{ \Illuminate\Support\Str::limit($berita->judul, 50) }}</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- Article Header Section -->
    <article class="page-shell py-12 md:py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Back to top fallback button (mobile) -->
            <div class="md:hidden mb-6" data-aos="fade-up">
                <a href="{{ route('frontend.berita') }}" class="back-button">
                    <i class="bi bi-chevron-left"></i> Kembali
                </a>
            </div>

            <!-- Article Header -->
            <header class="article-header mb-12" data-aos="fade-up" data-aos-delay="50">
                <!-- Article Title: Besar dan Bold -->
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-snug text-stone-900" style="font-family: 'Outfit', sans-serif;">
                    {{ $berita->judul }}
                </h1>

                <!-- Article Metadata: Tanggal, Penulis -->
                <div class="article-meta">
                    <div class="article-meta-item">
                        <i class="bi bi-calendar-event"></i>
                        <span>
                            <strong>{{ $berita->created_at->translatedFormat('d F Y') }}</strong>
                        </span>
                    </div>
                    <div class="article-meta-item">
                        <i class="bi bi-person-circle"></i>
                        <span>
                            <strong>{{ $berita->penulis ?? 'Admin' }}</strong>
                        </span>
                    </div>
                </div>

                <!-- Optional: Article Synopsis/Summary -->
                @if($berita->sinopsis)
                    <p class="text-lg md:text-xl text-stone-700 leading-relaxed italic border-l-4 border-accent pl-6 py-2 bg-accent/5 rounded-r-lg">
                        "{{ $berita->sinopsis }}"
                    </p>
                @endif
            </header>

            <!-- Article Hero Image -->
            <div class="article-hero-image mb-12" data-aos="zoom-in" data-aos-delay="100">
                @if($berita->gambar)
                    <img 
                        src="{{ asset('storage/' . $berita->gambar) }}" 
                        alt="{{ $berita->judul }}"
                        class="w-full h-auto object-cover"
                        loading="lazy"
                    >
                @else
                    <img 
                        src="{{ asset('storage/icon/FOTO.jpeg') }}" 
                        alt="Default"
                        class="w-full h-auto object-cover"
                    >
                @endif
            </div>

            <!-- Section Divider -->
            <div class="section-divider mb-8" data-aos="fade-right" data-aos-delay="150"></div>

            <!-- Article Content Body -->
            <div class="article-content bg-white p-8 md:p-10 rounded-xl border border-stone-100 shadow-md" data-aos="fade-up" data-aos-delay="200">
                {!! $berita->isi_berita !!}
            </div>

            <!-- Share & Back CTA -->
            <div class="mt-12 flex flex-col sm:flex-row gap-6 justify-between items-center" data-aos="fade-up" data-aos-delay="250">
                <div class="flex items-center gap-4">
                    <span class="text-stone-700 font-semibold">Bagikan artikel:</span>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" 
                           class="p-3 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300">
                            <i class="bi bi-facebook text-lg"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" rel="noopener noreferrer"
                           class="p-3 bg-sky-100 text-sky-600 rounded-full hover:bg-sky-600 hover:text-white transition-all duration-300">
                            <i class="bi bi-twitter text-lg"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}" target="_blank" rel="noopener noreferrer"
                           class="p-3 bg-green-100 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition-all duration-300">
                            <i class="bi bi-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>

                <a href="{{ route('frontend.berita') }}" class="back-button">
                    <i class="bi bi-arrow-left"></i>
                    <span>Lihat Berita Lain</span>
                </a>
            </div>
        </div>
    </article>

    <!-- Related Articles Section -->
    @if(!empty($berita_lain) && count($berita_lain) > 0)
        <section class="page-shell py-16 md:py-20 bg-white">
            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="mb-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-divider"></div>
                    <h2 class="text-3xl md:text-4xl font-black text-stone-900" style="font-family: 'Outfit', sans-serif;">
                        Berita Lainnya
                    </h2>
                    <p class="text-lg text-stone-600 mt-3">
                        Jangan lewatkan informasi penting lainnya dari masjid kami
                    </p>
                </div>

                <!-- Related Articles Grid -->
                <div class="related-articles-grid">
                    @foreach($berita_lain as $index => $item)
                        <div 
                            class="related-article-card"
                            data-aos="fade-up"
                            data-aos-delay="{{ 100 + (($index + 1) * 100) }}"
                        >
                            <!-- Image Container -->
                            <div class="related-article-image">
                                @if($item->gambar)
                                    <img 
                                        src="{{ asset('storage/' . $item->gambar) }}" 
                                        alt="{{ $item->judul }}"
                                        loading="lazy"
                                    >
                                @else
                                    <img 
                                        src="{{ asset('storage/icon/FOTO.jpeg') }}" 
                                        alt="Default"
                                    >
                                @endif
                            </div>

                            <!-- Content Container -->
                            <div class="related-article-content">
                                <span class="related-article-date">
                                    {{ $item->created_at->translatedFormat('d M Y') }}
                                </span>

                                <h3 class="related-article-title">
                                    {{ $item->judul }}
                                </h3>

                                <p class="related-article-excerpt">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->sinopsis ?? $item->isi_berita), 150) }}
                                </p>

                                <a href="{{ route('frontend.berita.show', $item->id) }}" class="related-article-link">
                                    Baca Selengkapnya
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA Section to Berita Index -->
        <section class="page-shell py-12">
            <div class="cta-section" data-aos="zoom-in" data-aos-delay="400">
                <h3>Ingin Membaca Berita Lainnya?</h3>
                <p>Kunjungi halaman berita kami untuk mendapatkan informasi terbaru dari DKM Al-Musabaqoh Subang</p>
                <a href="{{ route('frontend.berita') }}" class="cta-button">
                    <i class="bi bi-newspaper"></i>
                    Lihat Semua Berita
                </a>
            </div>
        </section>
    @endif
@endsection
