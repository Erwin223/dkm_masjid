<!DOCTYPE html>
<html lang="id">
@include('layouts._styles')
<head>
    <title>{{ trim($__env->yieldContent('title')) ?: trim($__env->yieldContent('page-title', 'Dashboard Admin')) . ' - DKM' }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')

</head>

<body>

    {{-- SIDEBAR OVERLAY (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="sidebar" id="sidebar">

        {{-- LOGO --}}
        <div class="sidebar-logo">
            <div class="logo-icon"><i class="fa-solid fa-mosque"></i></div>
            <div class="logo-text">
                <span>DKM Masjid Al-Musabaqoh</span>
                <small>Panel Admin</small>
            </div>
        </div>

        {{-- NAV --}}
        <div class="sidebar-nav">

            <div class="nav-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <a href="{{ route('pengurus.index') }}"
                class="nav-item {{ request()->routeIs('pengurus*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> Data Pengurus
            </a>

            <a href="{{ route('arsip.index') }}"
                class="nav-item {{ request()->routeIs('arsip*') ? 'active' : '' }}">
                <i class="fa fa-folder-open"></i> Arsip & Dokumen
            </a>

            <button
                class="nav-item {{ request()->routeIs('profil_masjid*') || request()->routeIs('berita*') || request()->routeIs('galeri*') ? 'active open' : '' }}"
                onclick="toggleDropdown('dd-konten', this)">
                <i class="fa fa-globe"></i> Kelola Website
                <i class="fa fa-chevron-right nav-arrow"></i>
            </button>
            <div class="nav-dropdown {{ request()->routeIs('profil_masjid*') || request()->routeIs('berita*') || request()->routeIs('galeri*') ? 'open' : '' }}"
                id="dd-konten">
                <a href="{{ route('profil_masjid.index') }}"
                    class="nav-item {{ request()->routeIs('profil_masjid*') ? 'active' : '' }}">
                    <i class="fa fa-mosque"></i> Profil Masjid
                </a>
                <a href="{{ route('berita.index') }}"
                    class="nav-item {{ request()->routeIs('berita*') ? 'active' : '' }}">
                    <i class="fa fa-newspaper"></i> Berita
                </a>
                <a href="{{ route('galeri.index') }}"
                    class="nav-item {{ request()->routeIs('galeri*') ? 'active' : '' }}">
                    <i class="fa fa-images"></i> Galeri
                </a>
            </div>

            {{-- KEGIATAN --}}
            <button
                class="nav-item {{ request()->routeIs('kegiatan*') || request()->routeIs('imam*') ? 'active open' : '' }}"
                onclick="toggleDropdown('dd-kegiatan', this)">
                <i class="fa fa-calendar"></i> Kegiatan
                <i class="fa fa-chevron-right nav-arrow"></i>
            </button>
            <div class="nav-dropdown {{ request()->routeIs('kegiatan*') || request()->routeIs('imam*') ? 'open' : '' }}"
                id="dd-kegiatan">
                <a href="{{ route('kegiatan.jadwal') }}"
                    class="nav-item {{ request()->routeIs('kegiatan.jadwal*') ? 'active' : '' }}">
                    <i class="fa fa-calendar-check"></i> Jadwal Kegiatan
                </a>
                <a href="{{ route('imam.data') }}"
                    class="nav-item {{ request()->routeIs('imam.data*') ? 'active' : '' }}">
                    <i class="fa fa-user-tie"></i> Data Imam
                </a>
                <a href="{{ route('kegiatan.imam') }}"
                    class="nav-item {{ request()->routeIs('kegiatan.imam*') ? 'active' : '' }}">
                    <i class="fa fa-calendar-days"></i> Jadwal Imam
                </a>
                <a href="{{ route('kegiatan.sholat') }}"
                    class="nav-item {{ request()->routeIs('kegiatan.sholat*') ? 'active' : '' }}">
                    <i class="fa fa-mosque"></i> Jadwal Sholat
                </a>
            </div>

            <div class="nav-divider"></div>
            <div class="nav-label">Keuangan</div>

            <button class="nav-item {{ request()->routeIs('kas*') ? 'active open' : '' }}"
                onclick="toggleDropdown('dd-kas', this)">
                <i class="fa fa-money-bill-wave"></i> Kas
                <i class="fa fa-chevron-right nav-arrow"></i>
            </button>
            <div class="nav-dropdown {{ request()->routeIs('kas*') ? 'open' : '' }}" id="dd-kas">
                <a href="{{ route('kas.masuk.index') }}"
                    class="nav-item {{ request()->routeIs('kas.masuk*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-down"></i> Kas Masuk
                </a>
                <a href="{{ route('kas.keluar.index') }}"
                    class="nav-item {{ request()->routeIs('kas.keluar*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-up"></i> Kas Keluar
                </a>
            </div>

            <button class="nav-item {{ request()->routeIs('donasi*') ? 'active open' : '' }}"
                onclick="toggleDropdown('dd-donasi', this)">
                <i class="fa fa-hand-holding-dollar"></i> Donasi
                <i class="fa fa-chevron-right nav-arrow"></i>
            </button>
            <div class="nav-dropdown {{ request()->routeIs('donasi*') ? 'open' : '' }}" id="dd-donasi">
                <a href="{{ route('donasi.masuk') }}"
                    class="nav-item {{ request()->routeIs('donasi.masuk*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-down"></i> Donasi Masuk
                </a>
                <a href="{{ route('donasi.keluar') }}"
                    class="nav-item {{ request()->routeIs('donasi.keluar*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-up"></i> Donasi Keluar
                </a>
            </div>
            <a href="{{ route('donatur.index') }}"
   class="nav-item {{ request()->routeIs('donatur*') ? 'active' : '' }}">
    <i class="fa fa-users"></i> Data Donatur
</a>
            <button class="nav-item {{ request()->routeIs('zakat*') ? 'active open' : '' }}"
                onclick="toggleDropdown('dd-zakat', this)">
                <i class="fa fa-hand-holding-heart"></i> Zakat
                <i class="fa fa-chevron-right nav-arrow"></i>
            </button>
            <div class="nav-dropdown {{ request()->routeIs('zakat*') ? 'open' : '' }}" id="dd-zakat">
                <a href="{{ route('zakat.muzakki.index') }}"
                    class="nav-item {{ request()->routeIs('zakat.muzakki*') ? 'active' : '' }}">
                    <i class="fa fa-user-plus"></i> Muzakki
                </a>
                <a href="{{ route('zakat.penerimaan.index') }}"
                    class="nav-item {{ request()->routeIs('zakat.penerimaan*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-down"></i> Penerimaan
                </a>
                <a href="{{ route('zakat.mustahik.index') }}"
                    class="nav-item {{ request()->routeIs('zakat.mustahik*') ? 'active' : '' }}">
                    <i class="fa fa-users"></i> Mustahik
                </a>
                <a href="{{ route('zakat.distribusi.index') }}"
                    class="nav-item {{ request()->routeIs('zakat.distribusi*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-up"></i> Distribusi
                </a>
            </div>
            <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> Laporan
            </a>

            <div class="nav-divider"></div>
            <div class="nav-label">Pengaturan</div>

            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fa fa-user-shield"></i> Kelola Admin
            </a>

        </div>

        {{-- BOTTOM --}}
        <div class="sidebar-bottom">

            {{-- TAMBAH ADMIN --}}
            <a href="{{ route('admin.users.create') }}" class="btn-tambah-admin">
                <div class="icon-circle"><i class="fa fa-user-plus"></i></div>
                Tambah Admin Baru
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </button>
            </form>

        </div>

    </div>

    {{-- ===================== MAIN ===================== --}}
    <div class="main" id="mainContent">

        {{-- NAVBAR --}}
        <div class="navbar">
            <div class="navbar-left">
                <button class="menu-btn" id="menu-toggle">
                    <i class="fa fa-bars"></i>
                </button>
                <span class="navbar-title">
                    @yield('page-title', 'Dashboard')
                </span>
            </div>

            <div class="navbar-right">
                {{-- NOTIFIKASI --}}
                <button class="nav-icon-btn">
                    <i class="fa-solid fa-bell"></i>
                    <span class="notif-dot"></span>
                </button>

                <div class="navbar-divider"></div>

                {{-- USER --}}
                <div class="user-pill">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content-scroll">
            <div class="container">
                <div class="content-inner">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('menu-toggle');
        const isMobile = () => window.innerWidth <= 768;

        menuBtn.addEventListener('click', function () {
            if (isMobile()) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('hide');
                main.classList.toggle('expanded');
            }
        });

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        function toggleDropdown(id, btn) {
            const dd = document.getElementById(id);
            const isOpen = dd.classList.contains('open');
            dd.classList.toggle('open', !isOpen);
            btn.classList.toggle('open', !isOpen);
        }

        // Tutup sidebar saat resize ke desktop
        window.addEventListener('resize', function () {
            if (!isMobile()) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
