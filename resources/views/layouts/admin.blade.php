<!DOCTYPE html>
<html lang="id">
@include('layouts._styles')

<head>
    <title>
        {{ trim($__env->yieldContent('title')) ?: trim($__env->yieldContent('page-title', 'Dashboard Admin')) . ' - DKM' }}
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')

</head>

<body>

    @php
        $authUser = auth()->user();
        $unreadNotifications = $authUser->unreadNotifications;
        $pendingKasKeluarNotif = collect();
        $pendingKegiatanNotif = collect();
        $pendingDonasiKeluarNotif = collect();
        $pendingDistribusiZakatNotif = collect();
        $pendingDeletionNotif = collect();
        $pendingApprovalCenterCount = 0;

        if ($authUser && $authUser->role === 'ketua') {
            $pendingKasKeluarNotif = \App\Models\KasKeluar::query()
                ->pending()
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            $pendingKegiatanNotif = \App\Models\JadwalKegiatan::query()
                ->pending()
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            $pendingDonasiKeluarNotif = \App\Models\DonasiKeluar::query()
                ->pending()
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            $pendingDistribusiZakatNotif = \App\Models\DistribusiZakat::query()
                ->pending()
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            $pendingDeletionNotif = \App\Models\DeletionRequest::query()
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            $pendingApprovalCenterCount =
                \App\Models\KasKeluar::query()->pending()->count() +
                \App\Models\JadwalKegiatan::query()->pending()->count() +
                \App\Models\DonasiKeluar::query()->pending()->count() +
                \App\Models\DistribusiZakat::query()->pending()->count() +
                \App\Models\DeletionRequest::query()->where('status', 'pending')->count();
        }

        $notifCount = $authUser && $authUser->role === 'ketua'
            ? max($unreadNotifications->count(), $pendingApprovalCenterCount)
            : $unreadNotifications->count();
    @endphp

    {{-- SIDEBAR OVERLAY (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="sidebar" id="sidebar">

        {{-- LOGO --}}
        <div class="sidebar-logo">
            <div class="logo-icon"><i class="fa-solid fa-mosque"></i></div>
            <div class="logo-text">
                <span>DKM Masjid Al-Musabaqoh</span>
                <small>
                    @if(auth()->user()?->role === 'ketua')
                        Panel Ketua
                    @else
                        Panel Admin
                    @endif
                </small>
            </div>
        </div>

        {{-- NAV --}}
        <div class="sidebar-nav">

            <div class="nav-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Dashboard
            </a>

            <a href="{{ route('admin.statistik') }}"
                class="nav-item {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
                <i class="fa fa-chart-pie"></i> Statistik
            </a>

            @if(auth()->user()->role != 'ketua')
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
            @endif

            <a href="{{ route('arsip.index') }}" class="nav-item {{ request()->routeIs('arsip*') ? 'active' : '' }}">
                <i class="fa fa-folder-open"></i> Arsip & Dokumen
            </a>

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
                @if(auth()->user()->role != 'ketua')
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
                @endif
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
            @if(auth()->user()->role != 'ketua')
                <a href="{{ route('donatur.index') }}"
                    class="nav-item {{ request()->routeIs('donatur*') ? 'active' : '' }}">
                    <i class="fa fa-users"></i> Data Donatur
                </a>
            @endif
            <button class="nav-item {{ request()->routeIs('zakat*') ? 'active open' : '' }}"
                onclick="toggleDropdown('dd-zakat', this)">
                <i class="fa fa-hand-holding-heart"></i> Zakat
                <i class="fa fa-chevron-right nav-arrow"></i>
            </button>
            <div class="nav-dropdown {{ request()->routeIs('zakat*') ? 'open' : '' }}" id="dd-zakat">
                @if(auth()->user()->role != 'ketua')
                    <a href="{{ route('zakat.muzakki.index') }}"
                        class="nav-item {{ request()->routeIs('zakat.muzakki*') ? 'active' : '' }}">
                        <i class="fa fa-user-plus"></i> Muzakki
                    </a>
                @endif
                <a href="{{ route('zakat.penerimaan.index') }}"
                    class="nav-item {{ request()->routeIs('zakat.penerimaan*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-down"></i> Penerimaan
                </a>
                @if(auth()->user()->role != 'ketua')
                    <a href="{{ route('zakat.mustahik.index') }}"
                        class="nav-item {{ request()->routeIs('zakat.mustahik*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i> Mustahik
                    </a>
                @endif
                <a href="{{ route('zakat.distribusi.index') }}"
                    class="nav-item {{ request()->routeIs('zakat.distribusi*') ? 'active' : '' }}">
                    <i class="fa fa-arrow-up"></i> Distribusi
                </a>
            </div>
            <a href="{{ route('admin.laporan.index') }}"
                class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> Laporan
            </a>

            <div class="nav-divider"></div>
            <div class="nav-label">Pengaturan</div>

            @if(auth()->user()->role == 'ketua')
                <a href="{{ route('admin.deletion_approvals.index') }}"
                    class="nav-item {{ request()->routeIs('admin.deletion_approvals*') ? 'active' : '' }}">
                    <i class="fa fa-clipboard-check"></i> Persetujuan Ketua
                    @if($pendingApprovalCenterCount > 0)
                        <span
                            style="margin-left:auto;background:#f59e0b;color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:999px;">{{ $pendingApprovalCenterCount }}</span>
                    @endif
                </a>
            @endif

            <a href="{{ route('admin.admins.index') }}"
                class="nav-item {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
                <i class="fa fa-user-shield"></i> Kelola User
            </a>

        </div>

        {{-- BOTTOM --}}
        <div class="sidebar-bottom">

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
                <div class="notif-wrapper" style="position: relative;">
                    <button class="nav-icon-btn" onclick="toggleNotifDropdown(event)">
                        <i class="fa-solid fa-bell"></i>
                        @if($notifCount > 0)
                            <span class="notif-dot"
                                style="width: auto; height: auto; min-width: 16px; padding: 2px 4px; border-radius: 10px; font-size: 10px; font-weight: bold; color: white; display: flex; align-items: center; justify-content: center; top: 0; right: 0;">{{ $notifCount }}</span>
                        @endif
                    </button>
                    <div class="notif-dropdown" id="notifDropdown"
                        style="display: none; position: absolute; right: 0; top: 120%; background: white; width: 320px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1px solid #eee; z-index: 100;">
                        <div
                            style="padding: 12px 16px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; font-size: 14px;">Notifikasi</span>
                            @if($unreadNotifications->count() > 0)
                                <form action="{{ route('admin.notifications.read_all') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit"
                                        style="background: none; border: none; color: #0f8b6d; font-size: 12px; cursor: pointer;">Tandai
                                        Semua Dibaca</button>
                                </form>
                            @endif
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @if($unreadNotifications->isNotEmpty())
                                @foreach($unreadNotifications->take(5) as $notif)
                                    <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST"
                                        style="margin: 0;">
                                        @csrf
                                        <button type="submit"
                                            style="width: 100%; text-align: left; padding: 12px 16px; border: none; background: #fff; border-bottom: 1px solid #f5f5f5; cursor: pointer; transition: background 0.2s;"
                                            onmouseover="this.style.background='#f8f9fa'"
                                            onmouseout="this.style.background='#fff'">
                                            <div style="font-size: 13px; font-weight: 600; color: #333; margin-bottom: 4px;">
                                                {{ $notif->data['title'] ?? 'Notifikasi' }}</div>
                                            <div style="font-size: 12px; color: #666; line-height: 1.4;">
                                                {{ $notif->data['message'] ?? '' }}</div>
                                            <div style="font-size: 10px; color: #999; margin-top: 6px;">
                                                {{ $notif->created_at->diffForHumans() }}</div>
                                        </button>
                                    </form>
                                @endforeach
                            @endif

                            @if($authUser && $authUser->role === 'ketua')
                                <div
                                    style="padding: 10px 16px; background:#f8fafc; border-top:1px solid #eef2f7; border-bottom:1px solid #eef2f7; font-size:12px; font-weight:700; color:#334155;">
                                    Persetujuan Pending
                                </div>
                                @if($pendingApprovalCenterCount > 0)
                                    @foreach($pendingKasKeluarNotif as $item)
                                        <a href="{{ route('admin.deletion_approvals.index') }}"
                                            style="display:block; text-decoration:none; padding:12px 16px; border-bottom:1px solid #f5f5f5; color:inherit;">
                                            <div style="font-size:13px; font-weight:600; color:#333;">Kas Keluar Menunggu Approval
                                            </div>
                                            <div style="font-size:12px; color:#666; line-height:1.4;">
                                                Rp.{{ number_format($item->nominal, 0, ',', '.') }} - {{ $item->jenis_pengeluaran }}
                                            </div>
                                            <div style="font-size:10px; color:#999; margin-top:6px;">
                                                {{ $item->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach

                                    @foreach($pendingKegiatanNotif as $item)
                                        <a href="{{ route('admin.deletion_approvals.index') }}"
                                            style="display:block; text-decoration:none; padding:12px 16px; border-bottom:1px solid #f5f5f5; color:inherit;">
                                            <div style="font-size:13px; font-weight:600; color:#333;">Jadwal Kegiatan Menunggu
                                                Approval</div>
                                            <div style="font-size:12px; color:#666; line-height:1.4;">{{ $item->nama_kegiatan }} -
                                                {{ optional($item->tanggal)->translatedFormat('d M Y') }}</div>
                                            <div style="font-size:10px; color:#999; margin-top:6px;">
                                                {{ $item->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach

                                    @foreach($pendingDonasiKeluarNotif as $item)
                                        <a href="{{ route('admin.deletion_approvals.index') }}"
                                            style="display:block; text-decoration:none; padding:12px 16px; border-bottom:1px solid #f5f5f5; color:inherit;">
                                            <div style="font-size:13px; font-weight:600; color:#333;">Donasi Keluar Menunggu Approval
                                            </div>
                                            <div style="font-size:12px; color:#666; line-height:1.4;">
                                                {{ $item->tujuan }} - Rp.{{ number_format($item->nilai_dana, 0, ',', '.') }}
                                            </div>
                                            <div style="font-size:10px; color:#999; margin-top:6px;">
                                                {{ $item->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach

                                    @foreach($pendingDistribusiZakatNotif as $item)
                                        <a href="{{ route('admin.deletion_approvals.index') }}"
                                            style="display:block; text-decoration:none; padding:12px 16px; border-bottom:1px solid #f5f5f5; color:inherit;">
                                            <div style="font-size:13px; font-weight:600; color:#333;">Distribusi Zakat Menunggu Approval
                                            </div>
                                            <div style="font-size:12px; color:#666; line-height:1.4;">
                                                {{ $item->mustahik->nama ?? 'Mustahik' }} - Rp.{{ number_format($item->nilai_dana, 0, ',', '.') }}
                                            </div>
                                            <div style="font-size:10px; color:#999; margin-top:6px;">
                                                {{ $item->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach

                                    @foreach($pendingDeletionNotif as $item)
                                        <a href="{{ route('admin.deletion_approvals.index') }}"
                                            style="display:block; text-decoration:none; padding:12px 16px; border-bottom:1px solid #f5f5f5; color:inherit;">
                                            <div style="font-size:13px; font-weight:600; color:#333;">Permintaan Hapus Menunggu
                                                Persetujuan</div>
                                            <div style="font-size:12px; color:#666; line-height:1.4;">
                                                {{ class_basename($item->model_type) }} diajukan {{ $item->user?->name ?? 'Admin' }}
                                            </div>
                                            <div style="font-size:10px; color:#999; margin-top:6px;">
                                                {{ $item->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach
                                @else
                                    <div style="padding: 20px; text-align: center; color: #999; font-size: 13px;">
                                        Tidak ada approval yang pending.
                                    </div>
                                @endif
                            @elseif($unreadNotifications->isEmpty())
                                <div style="padding: 20px; text-align: center; color: #999; font-size: 13px;">
                                    Belum ada notifikasi baru.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

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

        function toggleNotifDropdown(event) {
            event.stopPropagation();
            const dd = document.getElementById('notifDropdown');
            dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
        }

        // Close notif dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const notifWrapper = document.querySelector('.notif-wrapper');
            const notifDropdown = document.getElementById('notifDropdown');
            if (notifWrapper && notifDropdown && notifDropdown.style.display === 'block') {
                if (!notifWrapper.contains(event.target)) {
                    notifDropdown.style.display = 'none';
                }
            }
        });

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
