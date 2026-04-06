@extends('layouts.admin')

@section('content')

<style>
    .table-box {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e5e5e5;
        padding: 24px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
    }
    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }
    .table-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }
    .table-responsive { overflow-x:auto; }
    table {
        width:100%;
        border-collapse:collapse;
        min-width:780px;
        table-layout:fixed;
    }
    table th {
        background:#f8fafc;
        padding:14px 14px;
        font-size:13px;
        text-align:left;
        color:#374151;
        white-space:nowrap;
        border-bottom:1px solid #e5e7eb;
    }
    table td {
        padding:13px 14px;
        font-size:13px;
        border-bottom:1px solid #f3f4f6;
        vertical-align:top;
        color:#475569;
    }
    table tbody tr:hover { background:#f8fafc; }
    .title-cell, .summary-cell, .isi-cell { min-width:0; }
    .text-cell { display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .line-clamp-2 { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; overflow:hidden; white-space:normal; }
    .line-clamp-3 { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:3; overflow:hidden; white-space:normal; }
    .top-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; flex-wrap:wrap; gap:10px; }
    .search-input { height:38px; border:1px solid #d1d5db; border-radius:10px; padding:0 14px; font-size:13px; outline:none; min-width:220px; }
    .search-input:focus { border-color:#0f8b6d; box-shadow: 0 0 0 4px rgba(15, 139, 109, 0.1); }
    .btn-tambah { background:#0f8b6d; color:#fff; border:none; padding:10px 18px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:8px; text-decoration:none; box-shadow: 0 10px 24px rgba(15, 139, 109, 0.12); }
    .btn-tambah:hover { background:#0c6d55; color:#fff; transform: translateY(-1px); }
    .badge { font-size:12px; color:#0f6e56; background:#e1f5ee; padding:5px 12px; border-radius:20px; font-weight:600; }
    .thumb { width:56px; height:40px; object-fit:cover; border-radius:10px; border:1px solid #e5e7eb; background:#f3f3f3; }
    .td-note { color:#64748b; font-size:12px; }
    td i { transition:0.2s; }
    .fa-edit:hover  { color:#0e4eb0; transform:scale(1.15); }
    .fa-trash:hover { color:#c53030;  transform:scale(1.15); }
    @media(max-width:900px){
        table { min-width: 680px; }
    }
    @media(max-width:760px){
        .top-row { flex-direction:column; align-items:flex-start; }
        .search-input, .btn-tambah { width:100%; justify-content:center; }
        .table-box { padding:18px; }
    }
</style>

<h2>
    <i class="fa fa-newspaper"></i> Berita Masjid
</h2>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-newspaper" style="color:#0f8b6d;"></i> Daftar Berita</h3>
            <span class="badge" id="jmlBadge">{{ $data->count() }} berita</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari judul / penulis..." onkeyup="cariData()">
            <a href="{{ route('berita.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Penulis</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Sinopsis</th>
                    <th>Isi Berita</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $b->penulis }}</td>
                    <td>
                        @if($b->gambar)
                            <img class="thumb" src="{{ asset('storage/'.$b->gambar) }}" alt="gambar">
                        @else
                            <div class="thumb" style="display:flex;align-items:center;justify-content:center;color:#aaa;font-size:12px;">
                                -
                            </div>
                        @endif
                    </td>
                    <td class="title-cell"><span class="text-cell" title="{{ $b->judul }}">{{ $b->judul }}</span></td>
                    <td class="summary-cell"><span class="text-cell line-clamp-2" title="{{ strip_tags($b->sinopsis ?? $b->isi_berita) }}">{{ \Illuminate\Support\Str::limit($b->sinopsis ?? $b->isi_berita, 100) }}</span></td>
                    <td class="isi-cell"><span class="text-cell line-clamp-3" title="{{ strip_tags($b->isi_berita) }}">{{ \Illuminate\Support\Str::limit($b->isi_berita, 140) }}</span></td>
                    <td style="text-align:center;">
                        <form id="del-berita-{{ $b->id }}" action="{{ route('berita.delete', $b->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="hapus('del-berita-{{ $b->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('berita.edit', $b->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada berita
                    </td>
                </tr>
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
function cariData(){
    const q=document.getElementById('cariInput').value.toLowerCase();
    const rows=document.querySelectorAll('#tabelBody tr');
    let v=0;
    rows.forEach(r=>{ if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;} else r.style.display='none'; });
    document.getElementById('jmlBadge').textContent=v+' berita';
}
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>

@endsection

