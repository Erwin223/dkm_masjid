@php
    $navItems = $navItems ?? [
        ['label' => 'Beranda', 'href' => '#beranda', 'active' => true],
        ['label' => 'Profil Masjid', 'href' => '#profil', 'active' => false],
        ['label' => 'Berita', 'href' => '#berita', 'active' => false],
        ['label' => 'Galeri', 'href' => '#galeri', 'active' => false],
    ];
@endphp

<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-emerald-950/90 backdrop-blur-md border-b border-emerald-900/40 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ $navItems[0]['href'] ?? '#beranda' }}" class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-full bg-white p-1.5 flex items-center justify-center border-2 border-amber-500 shadow-md">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo DKM Subang" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="flex flex-col">
                    <span class="font-display text-lg md:text-xl font-extrabold text-white tracking-wide leading-tight">Al-Musabaqoh</span>
                    <span class="text-[10px] md:text-xs font-semibold text-amber-400 uppercase tracking-widest leading-none mt-1">Masjid Agung Subang</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-1.5" aria-label="Navigasi Utama">
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 {{ ($item['active'] ?? false) ? 'bg-emerald-900/40 text-amber-400 border border-emerald-800' : 'text-stone-200 hover:text-white hover:bg-emerald-900/60' }}">
                        @if($item['label'] === 'Beranda')
                            <i class="bi bi-house-door text-sm"></i>
                        @elseif($item['label'] === 'Profil Masjid')
                            <i class="bi bi-building text-sm"></i>
                        @elseif($item['label'] === 'Berita')
                            <i class="bi bi-newspaper text-sm"></i>
                        @elseif($item['label'] === 'Galeri')
                            <i class="bi bi-images text-sm"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="hidden md:flex items-center">
                <a href="{{ auth()->check() ? url('/admin/dashboard') : route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-extrabold uppercase tracking-wider rounded-full border border-emerald-600 shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="bi bi-box-arrow-in-right text-sm"></i> Login Admin
                </a>
            </div>

            <div class="flex md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-stone-200 hover:text-white focus:outline-none p-2 rounded-lg hover:bg-emerald-900/50" aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen">
                    <span class="sr-only">Buka Menu Navigasi</span>
                    <i class="bi" :class="mobileMenuOpen ? 'bi-x-lg text-2xl' : 'bi-list text-3xl'"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden bg-emerald-950 border-t border-emerald-900/60 px-4 py-4 space-y-2 shadow-2xl" id="mobile-menu" x-cloak>
        @foreach ($navItems as $item)
            <a href="{{ $item['href'] }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-stone-200 hover:text-white hover:bg-emerald-900/50 text-sm font-semibold transition-all {{ ($item['active'] ?? false) ? 'bg-emerald-900/50 text-amber-400 border border-emerald-800' : '' }}">
                @if($item['label'] === 'Beranda')
                    <i class="bi bi-house-door text-base text-amber-500"></i>
                @elseif($item['label'] === 'Profil Masjid')
                    <i class="bi bi-building text-base text-amber-500"></i>
                @elseif($item['label'] === 'Berita')
                    <i class="bi bi-newspaper text-base text-amber-500"></i>
                @elseif($item['label'] === 'Galeri')
                    <i class="bi bi-images text-base text-amber-500"></i>
                @endif
                {{ $item['label'] }}
            </a>
        @endforeach
        <div class="pt-4 border-t border-emerald-900/60 flex flex-col gap-2">
            <a href="{{ auth()->check() ? url('/admin/dashboard') : route('login') }}" @click="mobileMenuOpen = false" class="flex items-center justify-center gap-2 px-4 py-3 bg-emerald-700 text-white font-bold rounded-xl text-sm border border-emerald-600 transition">
                <i class="bi bi-box-arrow-in-right"></i> Login Admin
            </a>
        </div>
    </div>
</header>
