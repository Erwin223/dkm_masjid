@extends('layouts.admin')

@section('content')

    <style>
        .notif-success {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 999;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CARD STATISTIK */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .card {
            padding: 20px;
            border-radius: 8px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card i {
            font-size: 28px;
            opacity: 0.8;
        }

        .green {
            background: #28a745;
        }

        .blue {
            background: #17a2b8;
        }

        .orange {
            background: #fd7e14;
        }

        .purple {
            background: #6f42c1;
        }


        /* GRID DASHBOARD */

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }


        /* TABLE BOX */

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #f3f3f3;
            padding: 10px;
            text-align: left;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }


        /* TOTAL BOX */

        .total-box {
            text-align: center;
            margin-top: 20px;
        }


        /* BUTTON */

        .btn-tambah {
            background: #0f8b6d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-tambah:hover {
            background: #0c6d55;
        }


        /* WIDGET */

        .widget-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        td i {
            transition: 0.2s;
        }

        .fa-edit:hover {
            color: darkblue;
            transform: scale(1.2);
        }

        .fa-trash:hover {
            color: darkred;
            transform: scale(1.2);
        }
    </style>

<h2>
    <i class="fa-solid fa-chart-line"></i> Dashboard Admin
</h2>

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
                <h3>Kas Masuk</h3>
                <p>-</p>
            </div>
            <i class="fa-solid fa-money-bill-wave"></i>
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
                        <th style="text-align:center;">Aksi</th>
                        <th style="text-align:center;">Edit</th>
                    </tr>
                </thead>

                <tbody>

                    @if(isset($kasMasuk) && $kasMasuk->count())

                        @foreach($kasMasuk as $kas)

                            <tr>
                                <td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $kas->sumber }}</td>
                                <td>Rp.{{ number_format($kas->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $kas->keterangan ?? '-' }}</td>

                                <!-- DELETE -->
                                <td style="text-align:center;">
                                    <form id="delete-form-{{ $kas->id }}" action="{{ route('kas.masuk.delete', $kas->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" onclick="confirmDelete({{ $kas->id }})"
                                            style="border:none;background:none;cursor:pointer;">

                                            <i class="fa fa-trash" style="color:red;"></i>

                                        </button>

                                    </form>
                                </td>

                                <!-- EDIT -->
                                <td style="text-align:center;">
                                    <a href="{{ route('kas.masuk.edit', $kas->id) }}">
                                        <i class="fa fa-edit" style="color:blue;"></i>
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    @else

                        <tr>
                            <td colspan="6" style="text-align:center;">
                                Belum ada data
                            </td>
                        </tr>

                    @endif

                </tbody>

            </table>

            <div class="total-box">

                <strong>
                    Total Kas Masuk :
                    Rp.{{ isset($totalKasMasuk) ? number_format($totalKasMasuk, 0, ',', '.') : '0' }}
                </strong>

                <br><br>

                <a href="{{ route('kas.masuk.create') }}">
                    <button class="btn-tambah">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                </a>

            </div>

        </div>



        <!-- DATA KAS KELUAR-->

       <div class="table-box">

<h3><i class="fa-solid fa-money-bill-wave"></i> Data Kas Keluar</h3>

<table>

<thead>
<tr>
<th style="text-align:center;">Tanggal</th>
<th style="text-align:center;">Jenis Pengeluaran</th>
<th style="text-align:center;">Jumlah</th>
<th style="text-align:center;">Nominal</th>
<th style="text-align:center;">Keterangan</th>
<th style="text-align:center;">Aksi</th>
<th style="text-align:center;">Edit</th>
</tr>
</thead>

<tbody>

@if(isset($kasKeluar) && $kasKeluar->count())

@foreach($kasKeluar as $keluar)

<tr>
<td>{{ \Carbon\Carbon::parse($keluar->tanggal)->translatedFormat('d M Y') }}</td>
<td>{{ $keluar->jenis_pengeluaran }}</td>
<td>{{ $keluar->jumlah }}</td>
<td>Rp.{{ number_format($keluar->nominal, 0, ',', '.') }}</td>
<td>{{ $keluar->keterangan ?? '-' }}</td>

<!-- DELETE -->
<td style="text-align:center;">
<form id="delete-keluar-{{ $keluar->id }}"
action="{{ route('kas.keluar.delete', $keluar->id) }}"
method="POST">
@csrf
@method('DELETE')

<button type="button"
onclick="confirmDeleteKeluar({{ $keluar->id }})"
style="border:none;background:none;cursor:pointer;">

<i class="fa fa-trash" style="color:red;"></i>

</button>

</form>
</td>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<!-- EDIT -->
<td style="text-align:center;">
<a href="{{ route('kas.keluar.edit', $keluar->id) }}">
<i class="fa fa-edit" style="color:blue;"></i>
</a>
</td>

</tr>

@endforeach

@else

<tr>
<td colspan="7" style="text-align:center;">
Belum ada data
</td>
</tr>

@endif

</tbody>

</table>

<div class="total-box">

<strong>
Total Kas Keluar :
Rp.{{ isset($totalKasKeluar) ? number_format($totalKasKeluar, 0, ',', '.') : '0' }}
</strong>

<br><br>

<a href="{{ route('kas.keluar.create') }}">
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

    <!-- SCRIPT FIX -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
icon:'success',
title:'Berhasil!',
text:'{{ session('success') }}',
timer:2000,
showConfirmButton:false
});
</script>
@endif

<script>
function confirmDelete(id){
Swal.fire({
title:'Yakin hapus?',
icon:'warning',
showCancelButton:true
}).then((r)=>{
if(r.isConfirmed){
document.getElementById('delete-form-'+id).submit();
}
});
}

function confirmDeleteKeluar(id){
Swal.fire({
title:'Yakin hapus?',
icon:'warning',
showCancelButton:true
}).then((r)=>{
if(r.isConfirmed){
document.getElementById('delete-keluar-'+id).submit();
}
});
}
</script>
@endsection
