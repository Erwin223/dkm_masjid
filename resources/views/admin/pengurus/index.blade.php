@extends('layouts.admin')

@section('content')

@include('admin.pengurus._styles')

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
