@extends('layouts.admin')

@section('content')

@include('admin.kas_masuk._styles')
<div class="kas-header">
    <div class="kas-title">
        <div class="kas-icon"><i class="fa fa-money-bill-wave" style="color:#0f6e56;font-size:15px;"></i></div>
        Kas Masjid
    </div>
</div>

<div class="kas-nav">
    <a href="{{ route('kas.masuk.index') }}" {{ request()->routeIs('kas.masuk*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-down"></i> Kas Masuk
    </a>
    <a href="{{ route('kas.keluar.index') }}" {{ request()->routeIs('kas.keluar*') ? 'class=active' : '' }}>
        <i class="fa fa-arrow-up"></i> Kas Keluar
    </a>
</div>

<div class="summary-row">
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-arrow-down" style="color:#0f8b6d;"></i> Total Kas Masuk</div>
        <div class="s-value">Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ $data->count() }} transaksi</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">Rp.{{ number_format($masukBulanIni, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-list" style="color:#6f42c1;"></i> Transaksi Bulan Ini</div>
        <div class="s-value" style="color:#6f42c1;">{{ $jmlBulanIni }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">transaksi tercatat</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-down" style="color:#0f8b6d;"></i> Daftar Kas Masuk</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->count() }} data</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari sumber / keterangan..." onkeyup="cariData()">
            <a href="{{ route('kas.masuk.create') }}" class="btn-tambah">
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
                    <th>Sumber</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $kas)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}</td>
                    <td><span class="sumber-pill">{{ $kas->sumber }}</span></td>
                    <td style="font-weight:600;color:#0f8b6d;">Rp.{{ number_format($kas->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $kas->keterangan ?? '-' }}</td>
                    <td style="text-align:center;">
                        <form id="del-km-{{ $kas->id }}" action="{{ route('kas.masuk.delete', $kas->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="hapus('del-km-{{ $kas->id }}')" style="border:none;background:none;cursor:pointer;">
                                <i class="fa fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('kas.masuk.edit', $kas->id) }}">
                            <i class="fa fa-edit" style="color:blue;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data kas masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->count())
    <div style="margin-top:15px;display:flex;justify-content:flex-end;font-size:13px;">
        <strong>Total: Rp.{{ number_format($totalMasuk, 0, ',', '.') }}</strong>
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
