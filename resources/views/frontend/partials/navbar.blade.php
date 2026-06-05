@php
    $navItems = $navItems ?? [
        ['label' => 'Beranda', 'href' => '#beranda', 'active' => true, 'icon' => 'bi-house-door'],
        ['label' => 'Profil Masjid', 'href' => '#profil', 'active' => false, 'icon' => 'bi-building'],
        ['label' => 'Berita', 'href' => '#berita', 'active' => false, 'icon' => 'bi-newspaper'],
        [
            'label' => 'Kegiatan & Galeri',
            'href' => '#',
            'active' => false,
            'icon' => 'bi-collection',
            'dropdown' => [
                ['label' => 'Jadwal Kegiatan', 'href' => '#kegiatan', 'active' => false, 'icon' => 'bi-calendar-event'],
                ['label' => 'Galeri Foto', 'href' => '#galeri', 'active' => false, 'icon' => 'bi-images'],
            ]
        ],
        ['label' => 'Laporan', 'href' => route('frontend.laporan'), 'active' => false, 'icon' => 'bi-file-earmark-text'],
        ['label' => 'Donasi', 'href' => route('frontend.donasi'), 'active' => false, 'icon' => 'bi-heart-fill'],
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
                    @if(isset($item['dropdown']))
                        <div x-data="{ dropdownOpen: false }" class="relative" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                            <button class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 {{ ($item['active'] ?? false) ? 'bg-emerald-900/40 text-amber-400 border border-emerald-800' : 'text-stone-200 hover:text-white hover:bg-emerald-900/60' }}">
                                <i class="bi {{ $item['icon'] ?? 'bi-circle' }} text-sm"></i>
                                {{ $item['label'] }}
                                <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="dropdownOpen ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="dropdownOpen" x-transition.opacity.duration.200ms class="absolute left-0 mt-1 w-48 bg-white border border-stone-200 rounded-xl shadow-xl overflow-hidden z-50" x-cloak style="display: none;">
                                @foreach($item['dropdown'] as $subItem)
                                    <a href="{{ $subItem['href'] }}" class="block px-4 py-3 text-sm font-semibold text-stone-700 hover:text-emerald-700 hover:bg-emerald-50 transition-colors {{ ($subItem['active'] ?? false) ? 'bg-emerald-50 text-emerald-700' : '' }}">
                                        <i class="bi {{ $subItem['icon'] ?? 'bi-circle' }} mr-2 text-emerald-600"></i> {{ $subItem['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $item['href'] }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 {{ ($item['active'] ?? false) ? 'bg-emerald-900/40 text-amber-400 border border-emerald-800' : 'text-stone-200 hover:text-white hover:bg-emerald-900/60' }}">
                            <i class="bi {{ $item['icon'] ?? 'bi-circle' }} text-sm"></i>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>


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
            @if(isset($item['dropdown']))
                <div x-data="{ subMenuOpen: {{ ($item['active'] ?? false) ? 'true' : 'false' }} }" class="w-full">
                    <button @click="subMenuOpen = !subMenuOpen" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-stone-200 hover:text-white hover:bg-emerald-900/50 text-sm font-semibold transition-all {{ ($item['active'] ?? false) ? 'bg-emerald-900/50 text-amber-400 border border-emerald-800' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="bi {{ $item['icon'] ?? 'bi-circle' }} text-base text-amber-500"></i>
                            {{ $item['label'] }}
                        </div>
                        <i class="bi bi-chevron-down transition-transform duration-300" :class="subMenuOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="subMenuOpen" x-collapse class="pl-11 pr-4 py-2 space-y-1" style="display: none;">
                        @foreach($item['dropdown'] as $subItem)
                            <a href="{{ $subItem['href'] }}" @click="mobileMenuOpen = false" class="block py-2 text-sm text-stone-300 hover:text-white transition-colors {{ ($subItem['active'] ?? false) ? 'text-white font-bold' : '' }}">
                                <i class="bi {{ $subItem['icon'] ?? 'bi-circle' }} mr-2 text-amber-500/70"></i> {{ $subItem['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a href="{{ $item['href'] }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-stone-200 hover:text-white hover:bg-emerald-900/50 text-sm font-semibold transition-all {{ ($item['active'] ?? false) ? 'bg-emerald-900/50 text-amber-400 border border-emerald-800' : '' }}">
                    <i class="bi {{ $item['icon'] ?? 'bi-circle' }} text-base text-amber-500"></i>
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach

    </div>
</header>
