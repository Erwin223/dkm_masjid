@extends('layouts.admin')

@section('content')

@include('admin.kas_keluar._styles')

<div class="kas-header">
    <div class="kas-title">
        <div class="kas-icon"><i class="fa fa-money-bill-wave" style="color:#854f0b;font-size:15px;"></i></div>
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
        <div class="s-label"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Total Kas Keluar</div>
        <div class="s-value" style="color:#fd7e14;">Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">Approved saja yang memotong saldo</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-calendar" style="color:#17a2b8;"></i> Bulan Ini</div>
        <div class="s-value" style="color:#17a2b8;">Rp.{{ number_format($keluarBulanIni, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">Disetujui Ketua {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    </div>
    <div class="summary-card">
        <div class="s-label"><i class="fa fa-hourglass-half" style="color:#6f42c1;"></i> Menunggu Approval</div>
        <div class="s-value" style="color:#6f42c1;">Rp.{{ number_format($pendingKeluar, 0, ',', '.') }}</div>
        <div style="font-size:11px;color:#aaa;margin-top:4px;">{{ \App\Models\KasKeluar::pending()->count() }} transaksi pending</div>
    </div>
</div>

<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-arrow-up" style="color:#fd7e14;"></i> Daftar Kas Keluar</h3>
            <span style="font-size:12px;color:#633806;background:#faeeda;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $data->total() }} data</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari jenis / keterangan..." onkeyup="cariData()">
            <a href="{{ route('kas.keluar.create') }}" class="btn-tambah">
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
                    <th>Jenis Pengeluaran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Status Approval</th>
                    <th>Catatan Approval</th>
                    @if(auth()->user()->role == 'ketua')
                    <th style="text-align:center;">Aksi Ketua</th>
                    @endif
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($data as $i => $kas)
                <tr>
                    <td>{{ $data->firstItem() + $i }}</td>
                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->translatedFormat('d M Y') }}</td>
                    <td><span class="jenis-pill">{{ $kas->jenis_pengeluaran }}</span></td>
                    <td style="font-weight:600;color:#fd7e14;">Rp.{{ number_format($kas->nominal, 0, ',', '.') }}</td>
                    <td>{{ $kas->keterangan ?? '-' }}</td>
                    <td>
                        @php
                            $statusClasses = [
                                \App\Models\KasKeluar::STATUS_PENDING => ['#fef3c7', '#b45309', 'Pending'],
                                \App\Models\KasKeluar::STATUS_APPROVED => ['#dcfce7', '#166534', 'Approved'],
                                \App\Models\KasKeluar::STATUS_REJECTED => ['#fee2e2', '#b91c1c', 'Rejected'],
                            ];
                            [$bg, $color, $label] = $statusClasses[$kas->status] ?? ['#e5e7eb', '#374151', ucfirst($kas->status)];
                        @endphp
                        <span style="font-size:12px;background:{{ $bg }};color:{{ $color }};padding:4px 10px;border-radius:999px;font-weight:700;">
                            {{ $label }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#475569;">
                        @if($kas->status === \App\Models\KasKeluar::STATUS_APPROVED)
                            Disetujui {{ optional($kas->approved_at)->translatedFormat('d M Y H:i') ?? '-' }}
                            @if($kas->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $kas->approver->name }}</div>
                            @endif
                        @elseif($kas->status === \App\Models\KasKeluar::STATUS_REJECTED)
                            {{ $kas->rejection_reason }}
                            @if($kas->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $kas->approver->name }}</div>
                            @endif
                        @else
                            Menunggu persetujuan Ketua
                        @endif
                    </td>
                    @if(auth()->user()->role == 'ketua')
                    <td style="text-align:center;">
                        @can('approve', $kas)
                            <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
                                <form action="{{ route('kas.keluar.approve', $kas->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;" onclick="return confirm('Approve kas keluar ini? Saldo utama akan langsung terpotong.')">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                <form id="reject-kas-{{ $kas->id }}" action="{{ route('kas.keluar.reject', $kas->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rejection_reason" id="reject-kas-reason-{{ $kas->id }}">
                                    <button type="button" style="background:#dc2626;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;" onclick="rejectApproval('reject-kas-{{ $kas->id }}', 'reject-kas-reason-{{ $kas->id }}', 'kas keluar ini')">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="font-size:12px;color:#94a3b8;">-</span>
                        @endcan
                    </td>
                    @endif
                    @if($kas->deletionRequest)
                        <td colspan="2" style="text-align:center;">
                            <div style="margin-bottom:6px;">
                                <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                            </div>
                            @if(auth()->user()->role == 'ketua')
                                <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                                    <form action="{{ route('admin.deletion_approvals.approve', $kas->deletionRequest->id) }}" method="POST">
                                        @csrf
                                        <button style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Setuju" onclick="return confirm('Yakin setujui?')"><i class="fa fa-check"></i> Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.deletion_approvals.reject', $kas->deletionRequest->id) }}" method="POST">
                                        @csrf
                                        <button style="background: #ef4444; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Tidak" onclick="return confirm('Yakin tolak?')"><i class="fa fa-times"></i> Tidak</button>
                                    </form>
                                </div>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">-</span>
                            @endif
                        </td>
                    @else
                        <td style="text-align:center;">
                            @can('delete', $kas)
                                <form id="del-kk-{{ $kas->id }}" action="{{ route('kas.keluar.delete', $kas->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="hapus('del-kk-{{ $kas->id }}')" style="border:none;background:none;cursor:pointer;">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endcan
                        </td>
                        <td style="text-align:center;">
                            @can('update', $kas)
                                <a href="{{ route('kas.keluar.edit', $kas->id) }}">
                                    <i class="fa fa-edit" style="color:blue;"></i>
                                </a>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endcan
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="20" style="text-align:center;padding:2.5rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Belum ada data kas keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-pagination :paginator="$data" item="transaksi" />

    @if($data->total())
    <div style="margin-top:15px;display:flex;justify-content:flex-end;font-size:13px;">
        <strong>Total: Rp.{{ number_format($totalKeluar, 0, ',', '.') }}</strong>
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
        inputAttributes:{ 'aria-label':'Alasan penolakan' },
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
