@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')
<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-users" style="color:#0f8b6d;"></i> Data Mustahik</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} mustahik</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari nama / kategori..." onkeyup="cariData()">
            <a href="{{ route('zakat.mustahik.create') }}" class="btn-tambah"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><div style="display:flex;align-items:center;gap:10px;"><div class="avatar-init">{{ strtoupper(substr($item->nama, 0, 2)) }}</div><div style="font-weight:500;color:#111;">{{ $item->nama }}</div></div></td>
                    <td>{{ $item->alamat ?? '-' }}</td>
                    <td>{{ $item->no_hp ?? '-' }}</td>
                    <td><span class="badge-warn">{{ $item->kategori_mustahik }}</span></td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="hapus-mustahik-{{ $item->id }}" action="{{ route('zakat.mustahik.delete', $item->id) }}" method="POST" style="display:inline;">@csrf @method('DELETE')
                            <button type="button" onclick="hapus('hapus-mustahik-{{ $item->id }}')" style="border:none;background:none;cursor:pointer;"><i class="fa fa-trash" style="color:red;"></i></button>
                        </form>
                    </td>
                    <td style="text-align:center;"><a href="{{ route('zakat.mustahik.edit', $item->id) }}"><i class="fa fa-edit" style="color:blue;"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;padding:2.5rem;color:#999;"><i class="fa fa-users" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>Belum ada data mustahik</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif
<script>
function cariData(){const q=document.getElementById('cariInput').value.toLowerCase();const rows=document.querySelectorAll('#tabelBody tr');let v=0;rows.forEach(r=>{if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;}else r.style.display='none';});document.getElementById('jmlBadge').textContent=v+' mustahik';}
function hapus(formId){Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' }).then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });}
</script>
@endsection
