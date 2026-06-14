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
        <div style="font-size:11px;color:#aaa;margin-top:4px;">Approved saja yang mengurangi saldo donasi</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-bullseye" style="color:#6f42c1;"></i> Tujuan Unik</div>
        <div class="s-value" style="color:#6f42c1;">{{ \App\Models\DonasiKeluar::pluck('tujuan')->unique()->count() }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">tujuan penyaluran</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">Rp.{{ number_format($pendingKeluar, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">Menunggu approval ketua</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Daftar Donasi Keluar</h3>
            <span style="font-size:12px;color:#633806;background:#faeeda;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->total() }} data</span>
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
                    <th>Status Approval</th>
                    <th>Catatan Approval</th>
                    <th style="text-align:center;">Aksi Ketua</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $d)
                <tr>
                    <td>{{ $data->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d M Y') }}</td>
                    <td><span class="badge-jenis">{{ $d->jenis_donasi }}</span></td>
                    <td style="font-weight:500;color:#111;">{{ $d->tujuan }}</td>
                    <td>{{ $d->label_jumlah }}</td>
                    <td style="font-weight:600;color:#fd7e14;">Rp.{{ number_format($d->nilai_dana, 0, ',', '.') }}</td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                    <td>
                        @php
                            $statusClasses = [
                                \App\Models\DonasiKeluar::STATUS_PENDING => ['#fef3c7', '#b45309', 'Pending'],
                                \App\Models\DonasiKeluar::STATUS_APPROVED => ['#dcfce7', '#166534', 'Approved'],
                                \App\Models\DonasiKeluar::STATUS_REJECTED => ['#fee2e2', '#b91c1c', 'Rejected'],
                            ];
                            [$bg, $color, $label] = $statusClasses[$d->status] ?? ['#e5e7eb', '#374151', ucfirst($d->status ?? 'unknown')];
                        @endphp
                        <span style="font-size:12px;background:{{ $bg }};color:{{ $color }};padding:4px 10px;border-radius:999px;font-weight:700;">{{ $label }}</span>
                    </td>
                    <td style="font-size:12px;color:#475569;">
                        @if($d->status === \App\Models\DonasiKeluar::STATUS_APPROVED)
                            Disetujui {{ optional($d->approved_at)->translatedFormat('d M Y H:i') ?? '-' }}
                            @if($d->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $d->approver->name }}</div>
                            @endif
                        @elseif($d->status === \App\Models\DonasiKeluar::STATUS_REJECTED)
                            {{ $d->rejection_reason ?? 'Ditolak Ketua' }}
                            @if($d->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $d->approver->name }}</div>
                            @endif
                        @else
                            Menunggu persetujuan Ketua
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if(auth()->user()->role == 'ketua' && $d->status === \App\Models\DonasiKeluar::STATUS_PENDING)
                            <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
                                <form action="{{ route('donasi.keluar.approve', $d->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                <form id="reject-donasi-keluar-{{ $d->id }}" action="{{ route('donasi.keluar.reject', $d->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rejection_reason" id="reject-donasi-keluar-reason-{{ $d->id }}">
                                    <button type="button" style="background:#dc2626;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;" onclick="rejectApproval('reject-donasi-keluar-{{ $d->id }}', 'reject-donasi-keluar-reason-{{ $d->id }}', 'donasi keluar ini')">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="font-size:12px;color:#94a3b8;">-</span>
                        @endif
                    </td>
                    @if($d->deletionRequest)
                        @if(auth()->user()->role == 'ketua')
                            <td colspan="2" style="text-align:center;">
                                <div style="margin-bottom:6px;">
                                    <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                                </div>
                                <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                                    <form action="{{ route('admin.deletion_approvals.approve', $d->deletionRequest->id) }}" method="POST">
                                        @csrf
                                        <button style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Setuju" onclick="return confirm('Yakin setujui?')"><i class="fa fa-check"></i> Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.deletion_approvals.reject', $d->deletionRequest->id) }}" method="POST">
                                        @csrf
                                        <button style="background: #ef4444; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Tidak" onclick="return confirm('Yakin tolak?')"><i class="fa fa-times"></i> Tidak</button>
                                    </form>
                                </div>
                            </td>
                        @else
                            <td colspan="2" style="text-align:center;">
                                <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                            </td>
                        @endif
                    @else
                        <td style="text-align:center;">
                            @if($d->status === \App\Models\DonasiKeluar::STATUS_PENDING)
                                <form id="del-dk-{{ $d->id }}" action="{{ route('donasi.keluar.delete', $d->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="hapus('del-dk-{{ $d->id }}')" style="border:none;background:none;cursor:pointer;">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($d->status === \App\Models\DonasiKeluar::STATUS_PENDING)
                                <a href="{{ route('donasi.keluar.edit', $d->id) }}">
                                    <i class="fa fa-edit" style="color:blue;"></i>
                                </a>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endif
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="12" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data donasi keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-pagination :paginator="$data" item="transaksi" />

    @if($data->total())
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
function rejectApproval(formId, inputId, label){
    Swal.fire({
        title:'Tolak ' + label + '?',
        input:'textarea',
        inputLabel:'Alasan penolakan',
        inputPlaceholder:'Wajib diisi...',
        showCancelButton:true,
        confirmButtonText:'Tolak',
        cancelButtonText:'Batal',
        confirmButtonColor:'#dc2626',
        inputValidator:(value)=>{
            if(!value || !value.trim()){
                return 'Alasan penolakan wajib diisi.';
            }
        }
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById(inputId).value = result.value.trim();
            document.getElementById(formId).submit();
        }
    });
}
</script>

@endsection
