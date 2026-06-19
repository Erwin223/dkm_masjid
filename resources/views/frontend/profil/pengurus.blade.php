@extends('layouts.frontend')

@section('title', 'Susunan Pengurus Lengkap - DKM Al-Musabaqoh')

@section('content')
    <x-hero-banner
        badge="Struktur Kepengurusan"
        title="Susunan Pengurus"
        accent="Lengkap DKM"
        subtitle="Daftar pengurus inti dan statistik anggota divisi pengelola Masjid Al-Musabaqoh."
        :bg-image="asset('storage/icon/foto.webp')"
        icon="bi-people"
        badge-icon="bi-people"
    />

    <section class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <!-- Breadcrumbs / Back button -->
        <div class="mb-10" data-aos="fade-up">
            <a href="{{ route('frontend.profil') }}" class="inline-flex items-center gap-2 text-emerald-800 font-bold hover:text-emerald-700 transition">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Profil Masjid
            </a>
        </div>

        <!-- Section 1: Pengurus Inti -->
        <div class="mb-16" data-aos="fade-up">
            <div class="border-b border-stone-200 pb-5 mb-8">
                <h2 class="text-3xl font-black text-emerald-950">Pengurus Inti</h2>
                <p class="mt-2 text-stone-600">Daftar pengurus utama yang mengoordinasikan seluruh program kerja DKM.</p>
            </div>

            @if(count($pengurusInti) > 0)
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($pengurusInti as $item)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-stone-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <!-- Photo Section -->
                            @if($item->foto)
                                <div class="relative h-56 bg-gradient-to-br from-emerald-100 to-amber-50 overflow-hidden">
                                    <img src="{{ asset('storage/' . ltrim($item->foto, '/')) }}" 
                                        alt="{{ $item->nama }}" 
                                        class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                </div>
                            @else
                                <div class="h-56 bg-gradient-to-br from-emerald-400 to-amber-300 flex items-center justify-center">
                                    <i class="bi bi-person-circle text-white text-7xl"></i>
                                </div>
                            @endif

                            <!-- Content Section -->
                            <div class="p-8">
                                <p class="text-xs font-bold tracking-widest uppercase text-amber-600">
                                    {{ $item->jabatan }}
                                </p>
                                <h3 class="mt-3 text-2xl font-black text-emerald-950">
                                    {{ $item->nama }}
                                </h3>
                                
                                @if($item->no_hp)
                                    <div class="mt-6 pt-5 border-t border-stone-100">
                                        <p class="text-base text-stone-600 flex items-center font-semibold">
                                            <i class="bi bi-telephone-fill text-emerald-700 mr-3 text-lg"></i>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-800 hover:underline">
                                                {{ $item->no_hp }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-stone-50 border border-stone-200 rounded-3xl p-12 text-center text-stone-600">
                    Belum ada data pengurus inti.
                </div>
            @endif
        </div>

        <!-- Section 2: Anggota & Divisi (Agregasi) -->
        <div data-aos="fade-up" data-aos-delay="100">
            <div class="border-b border-stone-200 pb-5 mb-8">
                <h2 class="text-3xl font-black text-emerald-950">Divisi & Anggota</h2>
                <p class="mt-2 text-stone-600">Jumlah total anggota pendukung berdasarkan masing-masing divisi.</p>
            </div>

            @if(count($anggotaAgregasi) > 0)
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($anggotaAgregasi as $divisi)
                        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border border-stone-100 hover:shadow-lg transition flex items-center gap-5">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center flex-shrink-0 text-xl font-bold">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-stone-500 uppercase tracking-wider">{{ $divisi['jabatan'] }}</h4>
                                <p class="mt-1 text-lg font-black text-emerald-950">
                                    Total Anggota: {{ $divisi['total'] }} Orang
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-3xl p-8 text-center text-amber-800 flex items-center justify-center gap-3">
                    <i class="bi bi-info-circle-fill text-xl"></i>
                    <p class="font-medium text-base">Tidak ada data divisi/anggota pengurus saat ini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
