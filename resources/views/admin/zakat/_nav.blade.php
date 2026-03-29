<div class="zakat-nav">
    <a href="{{ route('zakat.muzakki.index') }}" {{ request()->routeIs('zakat.muzakki*') ? 'class=active' : '' }}>
        <i class="fa fa-user-plus"></i> Muzakki
    </a>
    <a href="{{ route('zakat.penerimaan.index') }}" {{ request()->routeIs('zakat.penerimaan*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-down"></i> Penerimaan Zakat
    </a>
    <a href="{{ route('zakat.mustahik.index') }}" {{ request()->routeIs('zakat.mustahik*') ? 'class=active' : '' }}>
        <i class="fa fa-users"></i> Mustahik
    </a>
    <a href="{{ route('zakat.distribusi.index') }}" {{ request()->routeIs('zakat.distribusi*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-up"></i> Distribusi Zakat
    </a>
</div>
