@extends('layouts.admin')

@section('content')

@include('admin.berita._styles')


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

