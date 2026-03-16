@extends('layouts.admin')

@section('content')

<style>

/* CARD STATISTIK */

.cards{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:15px;
margin-bottom:25px;
}

.card{
padding:20px;
border-radius:8px;
color:white;
display:flex;
justify-content:space-between;
align-items:center;
}

.card i{
font-size:28px;
opacity:0.8;
}

.green{background:#28a745;}
.blue{background:#17a2b8;}
.orange{background:#fd7e14;}
.purple{background:#6f42c1;}


/* GRID DASHBOARD */

.dashboard-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}


/* TABLE BOX */

.table-box{
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

table{
width:100%;
border-collapse:collapse;
margin-top:10px;
}

table th{
background:#f3f3f3;
padding:10px;
text-align:left;
}

table td{
padding:10px;
border-bottom:1px solid #eee;
}


/* TOTAL BOX */

.total-box{
text-align:center;
margin-top:20px;
}


/* BUTTON */

.btn-tambah{
background:#0f8b6d;
color:white;
border:none;
padding:10px 20px;
border-radius:6px;
cursor:pointer;
}

.btn-tambah:hover{
background:#0c6d55;
}


/* WIDGET */

.widget-box{
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

</style>



<h2><i class="fa-solid fa-chart-line"></i> Dashboard Admin</h2>

<div class="cards">

<div class="card green">
<div>
<h3>Total Donasi</h3>
<p>-</p>
</div>
<i class="fa-solid fa-sack-dollar"></i>
</div>

<div class="card blue">
<div>
<h3>Jadwal Kegiatan</h3>
<p>-</p>
</div>
<i class="fa-solid fa-calendar-days"></i>
</div>

<div class="card orange">
<div>
<h3>Total Jamaah</h3>
<p>-</p>
</div>
<i class="fa-solid fa-users"></i>
</div>

<div class="card purple">
<div>
<h3>Total Kas</h3>
<p>-</p>
</div>
<i class="fa-solid fa-wallet"></i>
</div>

</div>



<div class="dashboard-grid">


<!-- DATA KAS MASUK -->

<div class="table-box">

<h3><i class="fa-solid fa-table"></i> Data Kas Masuk</h3>

<table>

<thead>
<tr>
<th>Tanggal</th>
<th>Sumber</th>
<th>Jumlah</th>
<th>Keterangan</th>
</tr>
</thead>

<tbody>

@if(isset($kasMasuk) && $kasMasuk->count())

@foreach($kasMasuk as $kas)

<tr>
<td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}</td>
<td>{{ $kas->sumber }}</td>
<td>Rp.{{ number_format($kas->jumlah,0,',','.') }}</td>
<td>{{ $kas->keterangan }}</td>
</tr>

@endforeach

@else

<tr>
<td colspan="4" style="text-align:center;">
Belum ada data
</td>
</tr>

@endif

</tbody>

</table>


<div class="total-box">

<strong>
Total Kas Masuk :
Rp.{{ isset($totalKasMasuk) ? number_format($totalKasMasuk,0,',','.') : '0' }}
</strong>

<br><br>

<a href="{{ route('kas.create') }}">
<button class="btn-tambah">
<i class="fa fa-plus"></i> Tambah Data
</button>
</a>

</div>

</div>



<!-- WIDGET SAMPING -->

<div class="widget-box">

<h3><i class="fa-solid fa-bell"></i> Aktivitas Terbaru</h3>

<p>Belum ada aktivitas terbaru</p>

</div>

</div>


@endsection
