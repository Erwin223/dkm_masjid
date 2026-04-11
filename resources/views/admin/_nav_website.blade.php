<div class="website-header">
    <h2 class="website-title">
        <i class="fa fa-globe" style="color:#0f8b6d;"></i> Kelola Website
    </h2>
</div>

<div class="website-nav">
    <a href="{{ route('profil_masjid.index') }}" {{ request()->routeIs('profil_masjid*') ? 'class=active' : '' }}>
        <i class="fa fa-building"></i> Profil Masjid
    </a>
    <a href="{{ route('berita.index') }}" {{ request()->routeIs('berita*') ? 'class=active' : '' }}>
        <i class="fa fa-newspaper"></i> Berita
    </a>
    <a href="{{ route('galeri.index') }}" {{ request()->routeIs('galeri*') ? 'class=active' : '' }}>
        <i class="fa fa-images"></i> Galeri
    </a>

</div>
