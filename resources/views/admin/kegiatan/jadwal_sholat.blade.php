@extends('layouts.admin')

@section('content')

<style>
    /* HEADER */
    .keg-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px; }
    .keg-title  { font-size:20px; font-weight:600; color:#111; display:flex; align-items:center; gap:10px; }
    .keg-icon   { width:38px; height:38px; background:#e1f5ee; border-radius:10px; display:flex; align-items:center; justify-content:center; }

    /* DROPDOWN NAVIGASI */
    .keg-nav { display:flex; gap:10px; margin-bottom:25px; flex-wrap:wrap; }
    .keg-nav a {
        padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500;
        text-decoration:none; border:1px solid #ddd; color:#555; background:#fff;
        display:inline-flex; align-items:center; gap:7px; transition:0.2s;
    }
    .keg-nav a:hover        { background:#f0fbf6; border-color:#0f8b6d; color:#0f8b6d; }
    .keg-nav a.active       { background:#0f8b6d; border-color:#0f8b6d; color:#fff; }

    /* CARD WAKTU HARI INI */
    .sholat-today {
        display:grid; grid-template-columns:repeat(6,1fr); gap:12px; margin-bottom:25px;
    }
    .sholat-card {
        background:#fff; border-radius:12px; border:1px solid #e5e5e5;
        padding:16px 12px; text-align:center;
    }
    .sholat-card.aktif { background:#0f8b6d; border-color:#0f8b6d; }
    .sholat-card .waktu-label { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#999; margin-bottom:6px; }
    .sholat-card.aktif .waktu-label { color:rgba(255,255,255,.8); }
    .sholat-card .waktu-jam   { font-size:22px; font-weight:700; color:#111; }
    .sholat-card.aktif .waktu-jam   { color:#fff; }
    .sholat-card .waktu-icon  { font-size:18px; margin-bottom:8px; color:#0f8b6d; }
    .sholat-card.aktif .waktu-icon  { color:rgba(255,255,255,.9); }

    /* TABEL JADWAL BULANAN */
    .table-box { background:#fff; border-radius:10px; border:1px solid #e5e5e5; padding:20px; }
    .table-box h3 { font-size:15px; margin-bottom:15px; }
    .table-responsive { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:600px; }
    table th { background:#f3f3f3; padding:10px 12px; font-size:12px; text-align:center; white-space:nowrap; border-bottom:1px solid #e5e5e5; }
    table td { padding:9px 12px; font-size:13px; text-align:center; border-bottom:1px solid #f5f5f5; }
    table tbody tr:hover { background:#f7fdf9; }
    table tbody tr.today-row { background:#e1f5ee; font-weight:600; }
    table tbody tr.today-row td { color:#0f6e56; }

    /* KOTA SELECTOR */
    .kota-selector { display:flex; align-items:center; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
    .kota-selector select { height:36px; border:1px solid #ddd; border-radius:8px; padding:0 12px; font-size:13px; outline:none; color:#333; }
    .kota-selector select:focus { border-color:#0f8b6d; }
    .kota-selector .btn-refresh { background:#0f8b6d; color:#fff; border:none; padding:8px 16px; border-radius:8px; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; }
    .kota-selector .btn-refresh:hover { background:#0c6d55; }

    /* LOADING */
    .loading-box { text-align:center; padding:3rem; color:#999; }
    .loading-box i { font-size:28px; color:#0f8b6d; display:block; margin-bottom:10px; }

    /* INFO BADGE */
    .info-badge { font-size:12px; background:#e1f5ee; color:#0f6e56; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; }

    /* RESPONSIVE */
    @media(max-width:900px){ .sholat-today { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:600px){ .sholat-today { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:400px){ .sholat-today { grid-template-columns:1fr 1fr; } }
</style>

<div class="keg-header">
    <div class="keg-title">
        <div class="keg-icon">
            <i class="fa fa-calendar" style="color:#0f6e56;font-size:16px;"></i>
        </div>
        Kegiatan Masjid
    </div>
</div>

{{-- NAVIGASI DROPDOWN --}}
<div class="keg-nav">
    <a href="{{ route('kegiatan.jadwal') }}" {{ request()->routeIs('kegiatan.jadwal*') ? 'class=active' : '' }}>
        <i class="fa fa-calendar-check"></i> Jadwal Kegiatan
    </a>
    <a href="{{ route('imam.data') }}" {{ request()->routeIs('imam.data*') ? 'class=active' : '' }}>
        <i class="fa fa-user-tie"></i> Data Imam
    </a>
    <a href="{{ route('kegiatan.imam') }}" {{ request()->routeIs('kegiatan.imam*') ? 'class=active' : '' }}>
        <i class="fa fa-calendar-days"></i> Jadwal Imam
    </a>
    <a href="{{ route('kegiatan.sholat') }}" {{ request()->routeIs('kegiatan.sholat*') ? 'class=active' : '' }}>
        <i class="fa fa-mosque"></i> Jadwal Sholat
    </a>
</div>

{{-- JUDUL SECTION --}}
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
    <h3 style="font-size:17px;font-weight:600;margin:0;">
        <i class="fa fa-mosque" style="color:#0f8b6d;"></i> Jadwal Waktu Sholat
    </h3>
    <span class="info-badge">
        <i class="fa fa-circle-info"></i> Sumber: Kemenag RI via api.myquran.com
    </span>
</div>

{{-- KOTA SELECTOR --}}
<div class="kota-selector">
    <label style="font-size:13px;font-weight:500;color:#555;">Pilih Kota:</label>
    <select id="kotaSelect" onchange="gantiKota()">
        <option value="1201" data-nama="Kab. Bandung">Kab. Bandung</option>
        <option value="1202" data-nama="Kab. Bandung Barat">Kab. Bandung Barat</option>
        <option value="1203" data-nama="Kab. Bekasi">Kab. Bekasi</option>
        <option value="1204" data-nama="Kab. Bogor">Kab. Bogor</option>
        <option value="1205" data-nama="Kab. Ciamis">Kab. Ciamis</option>
        <option value="1206" data-nama="Kab. Cianjur">Kab. Cianjur</option>
        <option value="1207" data-nama="Kab. Cirebon">Kab. Cirebon</option>
        <option value="1208" data-nama="Kab. Garut">Kab. Garut</option>
        <option value="1209" data-nama="Kab. Indramayu">Kab. Indramayu</option>
        <option value="1210" data-nama="Kab. Karawang">Kab. Karawang</option>
        <option value="1211" data-nama="Kab. Kuningan">Kab. Kuningan</option>
        <option value="1212" data-nama="Kab. Majalengka">Kab. Majalengka</option>
        <option value="1213" data-nama="Kab. Pangandaran">Kab. Pangandaran</option>
        <option value="1214" data-nama="Kab. Purwakarta">Kab. Purwakarta</option>
        <option value="1215" data-nama="Kab. Subang">Kab. Subang</option>
        <option value="1216" data-nama="Kab. Sukabumi">Kab. Sukabumi</option>
        <option value="1217" data-nama="Kab. Sumedang">Kab. Sumedang</option>
        <option value="1218" data-nama="Kab. Tasikmalaya">Kab. Tasikmalaya</option>
        <option value="1219" data-nama="Kota Bandung" selected>Kota Bandung</option>
        <option value="1220" data-nama="Kota Banjar">Kota Banjar</option>
        <option value="1221" data-nama="Kota Bekasi">Kota Bekasi</option>
        <option value="1222" data-nama="Kota Bogor">Kota Bogor</option>
        <option value="1223" data-nama="Kota Cimahi">Kota Cimahi</option>
        <option value="1224" data-nama="Kota Cirebon">Kota Cirebon</option>
        <option value="1225" data-nama="Kota Depok">Kota Depok</option>
        <option value="1226" data-nama="Kota Sukabumi">Kota Sukabumi</option>
        <option value="1227" data-nama="Kota Tasikmalaya">Kota Tasikmalaya</option>
    </select>
    <button class="btn-refresh" onclick="muatJadwal()">
        <i class="fa fa-rotate-right"></i> Muat Ulang
    </button>
</div>

{{-- WAKTU SHOLAT HARI INI --}}
<div id="sholatHariIni">
    <div class="loading-box">
        <i class="fa fa-spinner fa-spin"></i>
        Memuat jadwal sholat...
    </div>
</div>

{{-- TABEL BULANAN --}}
<div class="table-box" style="margin-top:20px;">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <h3 style="margin:0;font-size:15px;">
            <i class="fa fa-table" style="color:#0f8b6d;"></i>
            Jadwal Sholat Bulanan — <span id="labelBulan"></span>
        </h3>
        <div style="display:flex;gap:8px;">
            <button onclick="gantiBulan(-1)" style="border:1px solid #ddd;background:#fff;border-radius:6px;padding:6px 12px;cursor:pointer;font-size:13px;">
                <i class="fa fa-chevron-left"></i>
            </button>
            <button onclick="gantiBulan(1)" style="border:1px solid #ddd;background:#fff;border-radius:6px;padding:6px 12px;cursor:pointer;font-size:13px;">
                <i class="fa fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table id="tabelBulanan">
            <thead>
                <tr>
                    <th>Tgl</th><th>Imsak</th><th>Subuh</th><th>Terbit</th>
                    <th>Dhuha</th><th>Dzuhur</th><th>Ashar</th><th>Maghrib</th><th>Isya</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                <tr><td colspan="9" class="loading-box"><i class="fa fa-spinner fa-spin"></i> Memuat...</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    const BULAN_NAMA = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    let now       = new Date();
    let tahunAkt  = now.getFullYear();
    let bulanAkt  = now.getMonth() + 1;
    let tanggalAkt= now.getDate();
    let kotaId    = '1301';

    function gantiKota(){
        kotaId = document.getElementById('kotaSelect').value;
        muatJadwal();
    }

    function gantiBulan(arah){
        bulanAkt += arah;
        if(bulanAkt > 12){ bulanAkt = 1; tahunAkt++; }
        if(bulanAkt < 1) { bulanAkt = 12; tahunAkt--; }
        muatBulanan();
    }

    function muatJadwal(){
        muatHariIni();
        muatBulanan();
    }

    async function muatHariIni(){
        const thn = now.getFullYear();
        const bln = String(now.getMonth()+1).padStart(2,'0');
        const tgl = String(now.getDate()).padStart(2,'0');
        const url = `https://api.myquran.com/v2/sholat/jadwal/${kotaId}/${thn}/${bln}/${tgl}`;
        const box = document.getElementById('sholatHariIni');
        box.innerHTML = '<div class="loading-box"><i class="fa fa-spinner fa-spin"></i> Memuat jadwal hari ini...</div>';
        try {
            const res  = await fetch(url);
            const json = await res.json();
            const d    = json.data;
            const j    = d.jadwal;
            const lokasi = d.lokasi;

            const waktuList = [
                { nama:'Imsak',   jam:j.imsak,   icon:'fa-moon'         },
                { nama:'Subuh',   jam:j.subuh,   icon:'fa-cloud-sun'    },
                { nama:'Dhuha',   jam:j.dhuha,   icon:'fa-sun'          },
                { nama:'Dzuhur',  jam:j.dzuhur,  icon:'fa-sun'          },
                { nama:'Ashar',   jam:j.ashar,   icon:'fa-cloud'        },
                { nama:'Maghrib', jam:j.maghrib, icon:'fa-cloud-moon'   },
                { nama:'Isya',    jam:j.isya,    icon:'fa-star-and-crescent'},
            ];

            const jamSekarang = now.getHours()*60 + now.getMinutes();
            let aktifIdx = -1;
            const times = [j.imsak,j.subuh,j.dhuha,j.dzuhur,j.ashar,j.maghrib,j.isya].map(t=>{
                const [h,m] = t.split(':').map(Number); return h*60+m;
            });
            for(let i=times.length-1;i>=0;i--){
                if(jamSekarang >= times[i]){ aktifIdx=i; break; }
            }

            let html = `<p style="font-size:13px;color:#666;margin-bottom:12px;">
                <i class="fa fa-location-dot" style="color:#0f8b6d;"></i> ${lokasi} &nbsp;|&nbsp;
                <i class="fa fa-calendar-day" style="color:#0f8b6d;"></i> ${j.tanggal}
            </p>
            <div class="sholat-today">`;

            waktuList.forEach((w,i)=>{
                const aktif = i===aktifIdx ? 'aktif' : '';
                html += `<div class="sholat-card ${aktif}">
                    <div class="waktu-icon"><i class="fa ${w.icon}"></i></div>
                    <div class="waktu-label">${w.nama}</div>
                    <div class="waktu-jam">${w.jam}</div>
                </div>`;
            });
            html += '</div>';
            box.innerHTML = html;
        } catch(e){
            box.innerHTML = '<div class="loading-box" style="color:#e74c3c;"><i class="fa fa-circle-exclamation"></i><br>Gagal memuat data. Periksa koneksi internet.</div>';
        }
    }

    async function muatBulanan(){
        const bln = String(bulanAkt).padStart(2,'0');
        const url = `https://api.myquran.com/v2/sholat/jadwal/${kotaId}/${tahunAkt}/${bln}`;
        document.getElementById('labelBulan').textContent = BULAN_NAMA[bulanAkt-1] + ' ' + tahunAkt;
        const tbody = document.getElementById('tabelBody');
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;padding:2rem;color:#999;"><i class="fa fa-spinner fa-spin"></i> Memuat...</td></tr>';
        try {
            const res  = await fetch(url);
            const json = await res.json();
            const list = json.data.jadwal;
            let rows = '';
            list.forEach(item=>{
                const isToday = (tahunAkt===now.getFullYear() && bulanAkt===(now.getMonth()+1) && parseInt(item.date.split('-')[2])===tanggalAkt);
                const cls = isToday ? 'today-row' : '';
                rows += `<tr class="${cls}">
                    <td><b>${item.date.split('-')[2]}</b></td>
                    <td>${item.imsak}</td><td>${item.subuh}</td><td>${item.terbit}</td>
                    <td>${item.dhuha}</td><td>${item.dzuhur}</td><td>${item.ashar}</td>
                    <td>${item.maghrib}</td><td>${item.isya}</td>
                </tr>`;
            });
            tbody.innerHTML = rows;
        } catch(e){
            tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;color:#e74c3c;padding:1.5rem;">Gagal memuat data bulanan.</td></tr>';
        }
    }

    muatJadwal();
</script>

@endsection
