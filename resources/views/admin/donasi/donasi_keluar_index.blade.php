@extends('layouts.admin')

@section('content')
@include('admin.donasi._styles')


<div class="don-header">
    <div class="don-title">
        <div class="don-icon"><i class="fa fa-hand-holding-dollar" style="color:#854f0b;font-size:16px;"></i></div>
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

<div class="summary-row">
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Total Donasi Keluar</div>
        <div class="s-value" style="color:#fd7e14;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ $data->count() }} transaksi</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-bullseye" style="color:#6f42c1;"></i> Tujuan Unik</div>
        <div class="s-value" style="color:#6f42c1;">{{ $data->pluck('tujuan')->unique()->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">tujuan penyaluran</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">{{ $data->filter(fn($d) => \Carbon\Carbon::parse($d->tanggal)->isCurrentMonth())->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Daftar Donasi Keluar</h3>
            <span style="font-size:12px;color:#633806;background:#faeeda;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} data</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari jenis / tujuan..." onkeyup="cariData()">
            <a href="{{ route('donasi.keluar.create') }}" class="btn-tambah">
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
                    <th>Jenis Donasi</th>
                    <th>Tujuan</th>
                    <th>Jumlah</th>
                    <th>Nominal</th>
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
                    <td><span class="badge-jenis">{{ $d->jenis_donasi }}</span></td>
                    <td style="font-weight:500;color:#111;">{{ $d->tujuan }}</td>
                    <td>{{ $d->label_jumlah }}</td>
                    <td style="font-weight:600;color:#fd7e14;">Rp.{{ number_format($d->nilai_dana, 0, ',', '.') }}</td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-dk-{{ $d->id }}" action="{{ route('donasi.keluar.delete', $d->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-dk-{{ $d->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('donasi.keluar.edit', $d->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data donasi keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->count())
    <div style="margin-top:15px;display:flex;justify-content:flex-end;font-size:13px;">
        <strong>Total Keseluruhan: Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</strong>
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
