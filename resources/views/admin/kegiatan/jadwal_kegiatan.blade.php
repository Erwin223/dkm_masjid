@extends('layouts.admin')
@section('content')
@include('admin.kegiatan._styles')



<div class="keg-header">
    <div class="keg-title">
        <div class="keg-icon">
            <i class="fa fa-calendar" style="color:#0f6e56;font-size:16px;"></i>
        </div>
        Kegiatan Masjid
    </div>
</div>

<div class="keg-nav">
    <a href="{{ route('kegiatan.jadwal') }}" {{ request()->routeIs('kegiatan.jadwal*') ? 'class=active' : '' }}>
        <i class="fa fa-calendar-check"></i> Jadwal Kegiatan
    </a>
    <a href="{{ route('imam.data') }}" {{ request()->routeIs('imam.data*') ? 'class=active' : '' }}>
        <i class="fa fa-user-tie"></i> Data Imam
    </a>
    <a href="{{ route('kegiatan.imam') }}" {{ request()->routeIs('kegiatan.imam*') ? 'class=active' : '' }}>
        <i class="fa fa-calendar-days"></i> Jadwal Imam
    </a>
    <a href="{{ route('kegiatan.sholat') }}" {{ request()->routeIs('kegiatan.sholat*') ? 'class=active' : '' }}>
        <i class="fa fa-mosque"></i> Jadwal Sholat
    </a>
</div>
<div class="table-box">
    <div class="top-row">
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <h3 style="margin:0;font-size:15px;"><i class="fa fa-calendar-check" style="color:#0f8b6d;"></i> Daftar Jadwal Kegiatan</h3>
            <span style="font-size:12px;color:#0f6e56;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="jmlBadge">{{ $kegiatan->total() }} kegiatan</span>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <input class="search-input" type="text" id="cariInput" placeholder="Cari kegiatan..." onkeyup="cariData()">
            <a href="{{ route('kegiatan.jadwal.create') }}" class="btn-tambah">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th><th>Nama Kegiatan</th><th>Tanggal Mulai</th><th>Tanggal Berakhir</th>
                    <th>Waktu</th><th>Tempat</th><th>Penanggung Jawab</th>
                    <th>Estimasi</th><th>Realisasi</th><th>Keterangan</th><th>Status Agenda</th>
                    <th>Status Approval</th><th>Catatan Approval</th>
                    @if(auth()->user()->role == 'ketua')
                    <th style="text-align:center;">Aksi Ketua</th>
                    @endif
                    <th style="text-align:center;">Hapus</th><th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody id="tabelBody">
                @forelse($kegiatan as $i => $k)
                <tr>
                    <td>{{ ($kegiatan->currentPage() - 1) * $kegiatan->perPage() + $loop->iteration }}</td>
                    <td><b>{{ $k->nama_kegiatan }}</b></td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $k->tanggal_selesai ? \Carbon\Carbon::parse($k->tanggal_selesai)->translatedFormat('d M Y') : '-' }}</td>
                    <td>{{ $k->waktu ?? '-' }}</td>
                    <td>{{ $k->tempat ?? '-' }}</td>
                    <td>{{ $k->penanggung_jawab ?? '-' }}</td>
                    <td>
                        @if($k->estimasi_anggaran)
                            <span class="anggaran-pill">
                                <i class="fa fa-wallet" style="font-size:10px;"></i>
                                Rp.{{ number_format($k->estimasi_anggaran, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="anggaran-none">belum diisi</span>
                        @endif
                    </td>
                    <td>
                        @if($k->kasKeluar)
                            <span class="anggaran-pill">
                                <i class="fa fa-money-bill" style="font-size:10px;"></i>
                                Rp.{{ number_format($k->kasKeluar->nominal, 0, ',', '.') }}
                            </span>
                            <div style="font-size:10px;color:#999;margin-top:2px;">{{ $k->kasKeluar->jenis_pengeluaran }}</div>
                        @else
                            <span class="anggaran-none">belum direalisasikan</span>
                        @endif
                    </td>
                    <td>{{ $k->keterangan ?? '-' }}</td>
                    <td>
                        @php
                            $tglMulai   = \Carbon\Carbon::parse($k->tanggal)->startOfDay();
                            $tglSelesai = $k->tanggal_selesai ? \Carbon\Carbon::parse($k->tanggal_selesai)->endOfDay() : $tglMulai->copy()->endOfDay();
                            $now        = now();
                        @endphp
                        @if($now->between($tglMulai, $tglSelesai))
                            <span class="badge-status badge-berjalan">Sedang Berlangsung</span>
                        @elseif($now->lt($tglMulai))
                            <span class="badge-status badge-akan">Akan Datang</span>
                        @else
                            <span class="badge-status badge-selesai">Selesai</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusClasses = [
                                \App\Models\JadwalKegiatan::STATUS_PENDING => ['#fef3c7', '#b45309', 'Pending'],
                                \App\Models\JadwalKegiatan::STATUS_APPROVED => ['#dcfce7', '#166534', 'Approved'],
                                \App\Models\JadwalKegiatan::STATUS_REJECTED => ['#fee2e2', '#b91c1c', 'Rejected'],
                            ];
                            [$bg, $color, $label] = $statusClasses[$k->status] ?? ['#e5e7eb', '#374151', ucfirst($k->status)];
                        @endphp
                        <span style="font-size:12px;background:{{ $bg }};color:{{ $color }};padding:4px 10px;border-radius:999px;font-weight:700;">
                            {{ $label }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#475569;">
                        @if($k->status === \App\Models\JadwalKegiatan::STATUS_APPROVED)
                            Tampil di website publik
                            <div style="margin-top:4px;color:#64748b;">
                                {{ optional($k->approved_at)->translatedFormat('d M Y H:i') ?? '-' }}
                                @if($k->approver)
                                    oleh {{ $k->approver->name }}
                                @endif
                            </div>
                        @elseif($k->status === \App\Models\JadwalKegiatan::STATUS_REJECTED)
                            {{ $k->rejection_reason }}
                            @if($k->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $k->approver->name }}</div>
                            @endif
                        @else
                            Belum tampil di website
                        @endif
                    </td>
                    @if(auth()->user()->role == 'ketua')
                    <td style="text-align:center;">
                        @can('approve', $k)
                            <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
                                <form action="{{ route('kegiatan.jadwal.approve', $k->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;" onclick="return confirm('Approve kegiatan ini agar tampil di website?')">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                <form id="reject-kegiatan-{{ $k->id }}" action="{{ route('kegiatan.jadwal.reject', $k->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rejection_reason" id="reject-kegiatan-reason-{{ $k->id }}">
                                    <button type="button" style="background:#dc2626;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;" onclick="rejectApproval('reject-kegiatan-{{ $k->id }}', 'reject-kegiatan-reason-{{ $k->id }}', 'kegiatan ini')">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="font-size:12px;color:#94a3b8;">-</span>
                        @endcan
                    </td>
                    @endif
                    @if($k->deletionRequest)
                        @if(auth()->user()->role == 'ketua')
                            <td colspan="2" style="text-align:center;">
                                <div style="margin-bottom:6px;">
                                    <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                                </div>
                                <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                                    <form action="{{ route('admin.deletion_approvals.approve', $k->deletionRequest->id) }}" method="POST">
                                        @csrf
                                        <button style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Setuju" onclick="return confirm('Yakin setujui?')"><i class="fa fa-check"></i> Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.deletion_approvals.reject', $k->deletionRequest->id) }}" method="POST">
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
                            @can('delete', $k)
                                <form id="del-keg-{{ $k->id }}" action="{{ route('kegiatan.jadwal.delete', $k->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="hapus('del-keg-{{ $k->id }}')" style="border:none;background:none;cursor:pointer;">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endcan
                        </td>
                        <td style="text-align:center;">
                            @can('update', $k)
                                <a href="{{ route('kegiatan.jadwal.edit', $k->id) }}">
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
                        Belum ada jadwal kegiatan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-pagination :paginator="$kegiatan" item="kegiatan" />
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif
<script>
function hapus(formId){
    Swal.fire({ title:'Yakin hapus?', text:'Data tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#0f8b6d', cancelButtonColor:'#d33', confirmButtonText:'Ya, hapus!', cancelButtonText:'Batal' })
    .then(r=>{ if(r.isConfirmed) document.getElementById(formId).submit(); });
}
function cariData(){
    const q=document.getElementById('cariInput').value.toLowerCase();
    const rows=document.querySelectorAll('#tabelBody tr');
    let v=0;
    rows.forEach(r=>{ if(r.textContent.toLowerCase().includes(q)){r.style.display='';v++;} else r.style.display='none'; });
    document.getElementById('jmlBadge').textContent=v+' kegiatan';
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
