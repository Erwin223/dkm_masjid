@extends('layouts.admin')

@section('content')

<style>
    /* CARD STATISTIK - sama seperti dashboard */
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

    .card i { font-size: 28px; opacity: 0.8; }
    .green  { background: #28a745; }
    .blue   { background: #17a2b8; }
    .orange { background: #fd7e14; }
    .purple { background: #6f42c1; }

    /* TABLE BOX  */
    .table-box {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .table-box h3 {
        margin-bottom: 5px;
        font-size: 20px;
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
        font-size: 13px;
    }

    table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
        vertical-align: middle;
    }

    td i { transition: 0.2s; }
    .fa-edit:hover  { color: darkblue; transform: scale(1.2); }
    .fa-trash:hover { color: darkred; transform: scale(1.2); }

    /* SEARCH & HEADER ROW */
    .pgr-top-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pgr-search {
        height: 36px;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 0 12px;
        font-size: 13px;
        outline: none;
        min-width: 200px;
    }

    .pgr-search:focus { border-color: #0f8b6d; }

    .pgr-badge {
        font-size: 12px;
        color: #085041;
        background: #e1f5ee;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* BUTTON */
    .btn-tambah {
        background: #0f8b6d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-tambah:hover { background: #0c6d55; color: white; }

    /* FOTO AVATAR */
    .pgr-avatar-img {
        width: 40px; height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #9fe1cb;
    }

    .pgr-avatar-initials {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #e1f5ee;
        border: 2px solid #9fe1cb;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        color: #0f6e56;
    }

    .pgr-avatar-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pgr-nama {
        font-weight: 500;
        color: #111 !important;
        font-size: 14px;
        display: block !important;
        opacity: 1 !important;
    }

    .pgr-sub {
        font-size: 11px;
        color: #999 !important;
        display: block !important;
    }

    .pgr-jabatan-pill {
        display: inline-block;
        background: #e1f5ee;
        color: #085041;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    /* RESPONSIVE  */
    @media (max-width: 992px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .cards {
            grid-template-columns: repeat(2, 1fr);
        }

        /* Tabel scroll */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table th, table td {
            white-space: nowrap;
            min-width: 100px;
        }

        .pgr-top-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .pgr-search { width: 100%; min-width: unset; }
    }

    @media (max-width: 480px) {
        .cards {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .card { padding: 14px; }
        .card h3 { font-size: 13px; }
        .card i  { font-size: 22px; }

        .btn-tambah { width: 100%; justify-content: center; }
    }
</style>

<h2>
    <i class="fa fa-users"></i> Data Pengurus
</h2>

<!-- CARD STATISTIK -->
<div class="cards">
    <div class="card green">
        <div>
            <h3>Total Pengurus</h3>
            <p>{{ count($data) }} orang</p>
        </div>
        <i class="fa fa-users"></i>
    </div>

    <div class="card blue">
        <div>
            <h3>Ketua</h3>
            <p>{{ $data->where('jabatan', 'Ketua')->count() }} orang</p>
        </div>
        <i class="fa fa-user-tie"></i>
    </div>

    <div class="card orange">
        <div>
            <h3>Sekretaris</h3>
            <p>{{ $data->where('jabatan', 'Sekretaris')->count() }} orang</p>
        </div>
        <i class="fa fa-user-edit"></i>
    </div>

    <div class="card purple">
        <div>
            <h3>Anggota Lainnya</h3>
            <p>{{ $data->whereNotIn('jabatan', ['Ketua','Sekretaris'])->count() }} orang</p>
        </div>
        <i class="fa fa-user-friends"></i>
    </div>
</div>

<!-- TABLE BOX -->
<div class="table-box">

    <div class="pgr-top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;"><i class="fa fa-table"></i> Daftar Pengurus</h3>
            <span class="pgr-badge" id="pgrBadge">{{ count($data) }} anggota</span>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <input class="pgr-search" type="text" id="pgrSearch" placeholder="Cari nama / jabatan..." onkeyup="pgrFilter()">
            <a href="{{ route('pengurus.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah Pengurus
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>No. HP</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="pgrTableBody">
                @forelse($data as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        @if($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}" class="pgr-avatar-img">
                        @else
                            <div class="pgr-avatar-initials">
                                {{ strtoupper(substr($p->nama, 0, 2)) }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="pgr-nama">{{ $p->nama }}</span>
                        <span class="pgr-sub">#{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td>
                        <span class="pgr-jabatan-pill">{{ $p->jabatan }}</span>
                    </td>
                    <td>
                        <i class="fa fa-phone" style="color:#aaa;font-size:11px;margin-right:5px;"></i>
                        {{ $p->no_hp }}
                    </td>

                    <!-- DELETE -->
                    <td style="text-align:center;">
                        <form id="delete-{{ $p->id }}" action="{{ route('pengurus.delete', $p->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="hapus({{ $p->id }})" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>

                    <!-- EDIT -->
                    <td style="text-align:center;">
                        <a href="{{ route('pengurus.edit', $p->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#999;padding:2rem;">
                        <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data pengurus
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;text-align:right;">
        <span id="pgrFooter" style="font-size:12px;color:#999;">Menampilkan {{ count($data) }} data</span>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil!',
    text:'{{ session("success") }}',
    timer:2000,
    showConfirmButton:false
});
</script>
@endif

<script>
function pgrFilter(){
    const q = document.getElementById('pgrSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#pgrTableBody tr');
    let v = 0;
    rows.forEach(r => {
        if(r.textContent.toLowerCase().includes(q)){ r.style.display=''; v++; }
        else r.style.display='none';
    });
    document.getElementById('pgrBadge').textContent = v + ' anggota';
    document.getElementById('pgrFooter').textContent = 'Menampilkan ' + v + ' data';
}

function hapus(id){
    Swal.fire({
        title:'Yakin hapus?',
        text:'Data tidak bisa dikembalikan!',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#0f8b6d',
        cancelButtonColor:'#d33',
        confirmButtonText:'Ya, hapus!',
        cancelButtonText:'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('delete-'+id).submit();
        }
    });
}
</script>

@endsection
