<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard Admin — DKM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            background: #f0f2f5;
            min-height: 100vh;
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: 250px;
            background: #0a6b53;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar.hide {
            transform: translateX(-250px);
        }

        /* LOGO */
        .sidebar-logo {
            padding: 22px 20px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-logo .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar-logo .logo-text {
            line-height: 1.2;
        }

        .sidebar-logo .logo-text span {
            display: block;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .sidebar-logo .logo-text small {
            font-size: 11px;
            opacity: 0.65;
        }

        /* NAV LABEL */
        .nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.5;
            padding: 18px 20px 6px;
        }

        /* NAV ITEMS */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 8px 12px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 2px;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.18s;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 14px;
            opacity: 0.85;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.12);
            color: white;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.18);
            color: white;
            font-weight: 600;
        }

        /* DROPDOWN NAV */
        .nav-dropdown {
            display: none;
            padding-left: 14px;
        }

        .nav-dropdown.open {
            display: block;
        }

        .nav-dropdown .nav-item {
            font-size: 12.5px;
            padding: 8px 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-dropdown .nav-item i {
            font-size: 12px;
        }

        .nav-item .nav-arrow {
            margin-left: auto;
            font-size: 11px;
            opacity: 0.6;
            transition: transform 0.2s;
        }

        .nav-item.open .nav-arrow {
            transform: rotate(90deg);
        }

        /* DIVIDER */
        .nav-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 10px 0;
        }

        /* SIDEBAR BOTTOM */
        .sidebar-bottom {
            padding: 14px 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .btn-tambah-admin {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 14px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px dashed rgba(255, 255, 255, 0.35);
            border-radius: 9px;
            color: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 10px;
        }

        .btn-tambah-admin:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.6);
            color: white;
        }

        .btn-tambah-admin .icon-circle {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            background: none;
            border: none;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.18s;
            text-align: left;
        }

        .btn-logout:hover {
            background: rgba(220, 53, 69, 0.25);
            color: #ffb3b3;
        }

        .btn-logout i {
            width: 18px;
            text-align: center;
        }

        /* ===================== MAIN ===================== */
        .main {
            flex: 1;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main.expanded {
            margin-left: 0;
        }

        /* NAVBAR */
        .navbar {
            background: white;
            padding: 0 24px;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e8e8e8;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-btn {
            background: none;
            border: none;
            color: #555;
            font-size: 18px;
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .menu-btn:hover {
            background: #f0f0f0;
        }

        .navbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #222;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-icon-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 9px;
            background: none;
            border: none;
            color: #666;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            text-decoration: none;
        }

        .nav-icon-btn:hover {
            background: #f0f0f0;
            color: #333;
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #e74c3c;
            border-radius: 50%;
            border: 2px solid white;
        }

        .navbar-divider {
            width: 1px;
            height: 28px;
            background: #e8e8e8;
            margin: 0 6px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 5px 12px 5px 5px;
            border-radius: 30px;
            border: 1px solid #e8e8e8;
            cursor: pointer;
            transition: background 0.2s;
            background: white;
            text-decoration: none;
        }

        .user-pill:hover {
            background: #f8f8f8;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            background: #0f8b6d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: white;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        /* BREADCRUMB */
        .breadcrumb-bar {
            padding: 10px 24px;
            font-size: 12px;
            color: #999;
            border-bottom: 1px solid #ebebeb;
            background: white;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb-bar a {
            color: #0f8b6d;
            text-decoration: none;
        }

        .breadcrumb-bar a:hover {
            text-decoration: underline;
        }

        /* CONTENT */
        .container {
            padding: 24px;
            flex: 1;
        }

        /* OVERLAY mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 90;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0 !important;
            }

            .container {
                padding: 16px;
            }

            .navbar {
                padding: 0 16px;
            }

            .navbar-title {
                display: none;
            }
        }
    </style>
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

            {{-- KEGIATAN DROPDOWN --}}
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
            <a href="#" class="nav-item">
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
        <div class="container">
            @yield('content')
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

</body>

</html>
