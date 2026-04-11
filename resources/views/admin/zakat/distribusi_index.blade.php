@extends('layouts.admin')
@section('content')
@include('admin.zakat._styles')
@include('admin.zakat._nav')



<style>
    /* FIX UI: Layout Jumlah agar tidak menumpuk seperti di Penerimaan */
    .jumlah-wrapper {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 100px;
    }
    .jumlah-top {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .jumlah-main {
        font-weight: 700;
        color: #0f8b6d;
        font-size: 16px;
        white-space: nowrap;
    }
    .jumlah-unit {
        display: inline-flex;
        padding: 2px 6px;
        border-radius: 12px;
        background: #eef7f3;
        color: #0d6b54;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }
</style>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-up" style="color:#0f8b6d;"></i> Distribusi Zakat</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} distribusi</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari mustahik / jenis..." onkeyup="cariData()">
            <a href="{{ route('zakat.distribusi.create') }}" class="btn-tambah"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mustahik</th>
                    <th>Tanggal</th>
                    <th>Jenis Zakat</th>
                    <th>Bentuk</th>
                    <th>Jumlah Disalurkan (Barang)</th>
                    <th>Nominal (Uang)</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $item->mustahik->nama ?? '-' }}</strong><br>
                        <span style="font-size:11px; color:#7a7a7a;">{{ $item->mustahik->kategori_mustahik ?? '-' }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                    <td><span class="badge-soft">{{ $item->jenis_zakat }}</span></td>
                    <td><span class="badge-warn">{{ $item->bentuk_zakat ?? 'Uang' }}</span></td>

                    <td>
                        @if($item->bentuk_zakat === 'Barang')
                            <div class="jumlah-wrapper">
                                <div class="jumlah-top">
                                    {{-- FIX: Menggunakan (float) agar 5.50 tampil sebagai 5.5 --}}
                                    <span class="jumlah-main">{{ (float) $item->jumlah_zakat }}</span>
                                    @if($item->satuan)
                                        <span class="jumlah-unit">{{ $item->satuan }}</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <span style="color:#999;">-</span>
                        @endif
                    </td>

                    <td>{{ $item->nominal ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>

                    <td style="text-align:center;">
                        <form id="hapus-distribusi-{{ $item->id }}" action="{{ route('zakat.distribusi.delete', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('hapus-distribusi-{{ $item->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('zakat.distribusi.edit', $item->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" style="text-align:center;padding:2.5rem;color:#999;"><i class="fa fa-arrow-up" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>Belum ada distribusi zakat</td></tr>
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
function cariData(){const q=document.getElementById('cariInput').value.toLowerCase();const rows=document.querySelectorAll('#tabelBody tr');let v=0;rows.forEach(r=>{if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;}else r.style.display='none';});document.getElementById('jmlBadge').textContent=v+' distribusi';}
function hapus(formId){Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' }).then(r=>{if(r.isConfirmed) document.getElementById(formId).submit();});}
</script>
@endsection
