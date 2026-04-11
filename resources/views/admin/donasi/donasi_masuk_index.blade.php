@extends('layouts.admin')
@section('content')
@include('admin.donasi._styles')


<div class="don-header">
    <div class="don-title">
        <div class="don-icon"><i class="fa fa-hand-holding-dollar" style="color:#0f6e56;font-size:16px;"></i></div>
        Donasi
    </div>
</div>

<div class="don-nav">
    <a href="{{ route('donasi.masuk') }}" {{ request()->routeIs('donasi.masuk*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-down"></i> Donasi Masuk
    </a>
    <a href="{{ route('donasi.keluar') }}" {{ request()->routeIs('donasi.keluar*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-up"></i> Donasi Keluar
    </a>
</div>

{{-- SUMMARY CARDS --}}
<div class="summary-row">
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-arrow-down" style="color:#0f8b6d;"></i> Total Donasi Masuk</div>
        <div class="s-value">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ $data->count() }} transaksi</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-hand-holding-heart" style="color:#6f42c1;"></i> Donatur Unik</div>
        <div class="s-value" style="color:#6f42c1;">{{ $data->pluck('donatur_nama')->unique()->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">donatur terdaftar</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Transaksi Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">{{ $data->filter(fn($d) => \Carbon\Carbon::parse($d->tanggal)->isCurrentMonth())->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-down" style="color:#0f8b6d;"></i> Daftar Donasi Masuk</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} data</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari donatur / jenis..." onkeyup="cariData()">
            <a href="{{ route('donasi.masuk.create') }}" class="btn-tambah">
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
                    <th>Donatur</th>
                    <th>Jenis Donasi</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:30px;height:30px;border-radius:50%;background:#e1f5ee;border:2px solid #9fe1cb;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#0f6e56;flex-shrink:0;">
                                {{ strtoupper(substr($d->donatur_nama ?? 'HA', 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:500;color:#111;">{{ $d->donatur_nama ?? 'Hamba Allah' }}</div>
                                @if($d->donatur)
                                    <div style="font-size:10px;color:#0f8b6d;">Terdaftar</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="badge-jenis">{{ $d->jenis_donasi }}</span></td>
                    <td><span class="badge-kategori">{{ $d->kategori_donasi }}</span></td>
                    <td>{{ $d->is_barang ? $d->label_jumlah : '-' }}</td>
                    <td style="font-weight:600;color:#0f8b6d;">Rp.{{ number_format($d->nilai_dana, 0, ',', '.') }}</td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-dm-{{ $d->id }}" action="{{ route('donasi.masuk.delete', $d->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-dm-{{ $d->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('donasi.masuk.edit', $d->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data donasi masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->count())
    <div style="margin-top:15px;display:flex;justify-content:flex-end;font-size:13px;">
        <strong>Total Keseluruhan: Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</strong>
    </div>
    @endif
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
    document.getElementById('jmlBadge').textContent=v+' data';
}
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>

@endsection
