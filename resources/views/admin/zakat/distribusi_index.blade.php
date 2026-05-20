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
                    <th>Status Approval</th>
                    <th>Catatan Approval</th>
                    <th style="text-align:center;">Aksi Ketua</th>
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
                    <td>
                        @php
                            $statusClasses = [
                                \App\Models\DistribusiZakat::STATUS_PENDING => ['#fef3c7', '#b45309', 'Pending'],
                                \App\Models\DistribusiZakat::STATUS_APPROVED => ['#dcfce7', '#166534', 'Approved'],
                                \App\Models\DistribusiZakat::STATUS_REJECTED => ['#fee2e2', '#b91c1c', 'Rejected'],
                            ];
                            [$bg, $color, $label] = $statusClasses[$item->status] ?? ['#e5e7eb', '#374151', ucfirst($item->status ?? 'unknown')];
                        @endphp
                        <span style="font-size:12px;background:{{ $bg }};color:{{ $color }};padding:4px 10px;border-radius:999px;font-weight:700;">{{ $label }}</span>
                    </td>
                    <td style="font-size:12px;color:#475569;">
                        @if($item->status === \App\Models\DistribusiZakat::STATUS_APPROVED)
                            Disetujui {{ optional($item->approved_at)->translatedFormat('d M Y H:i') ?? '-' }}
                            @if($item->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $item->approver->name }}</div>
                            @endif
                        @elseif($item->status === \App\Models\DistribusiZakat::STATUS_REJECTED)
                            {{ $item->rejection_reason ?? 'Ditolak Ketua' }}
                            @if($item->approver)
                                <div style="margin-top:4px;color:#64748b;">oleh {{ $item->approver->name }}</div>
                            @endif
                        @else
                            Menunggu persetujuan Ketua
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if(auth()->user()->role == 'ketua' && $item->status === \App\Models\DistribusiZakat::STATUS_PENDING)
                            <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
                                <form action="{{ route('zakat.distribusi.approve', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:#16a34a;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                <form id="reject-distribusi-{{ $item->id }}" action="{{ route('zakat.distribusi.reject', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rejection_reason" id="reject-distribusi-reason-{{ $item->id }}">
                                    <button type="button" style="background:#dc2626;color:#fff;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;" onclick="rejectApproval('reject-distribusi-{{ $item->id }}', 'reject-distribusi-reason-{{ $item->id }}', 'distribusi zakat ini')">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="font-size:12px;color:#94a3b8;">-</span>
                        @endif
                    </td>

                    @if($item->deletionRequest)
                        @if(auth()->user()->role == 'ketua')
                            <td colspan="2" style="text-align:center;">
                                <div style="margin-bottom:6px;">
                                    <span style="font-size:12px;color:#b45309;background:#fef3c7;padding:4px 10px;border-radius:12px;font-weight:600;">Menunggu Dihapus</span>
                                </div>
                                <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                                    <form action="{{ route('admin.deletion_approvals.approve', $item->deletionRequest->id) }}" method="POST">
                                        @csrf
                                        <button style="background: #10b981; color: white; border: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; font-size: 11px;" type="submit" title="Setuju" onclick="return confirm('Yakin setujui?')"><i class="fa fa-check"></i> Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.deletion_approvals.reject', $item->deletionRequest->id) }}" method="POST">
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
                            @if($item->status === \App\Models\DistribusiZakat::STATUS_PENDING)
                                <form id="hapus-distribusi-{{ $item->id }}" action="{{ route('zakat.distribusi.delete', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="hapus('hapus-distribusi-{{ $item->id }}')" style="border:none;background:none;cursor:pointer;">
                                        <i class="fa fa-trash" style="color:red;"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($item->status === \App\Models\DistribusiZakat::STATUS_PENDING)
                                <a href="{{ route('zakat.distribusi.edit', $item->id) }}">
                                    <i class="fa fa-edit" style="color:blue;"></i>
                                </a>
                            @else
                                <span style="font-size:12px;color:#94a3b8;">Terkunci</span>
                            @endif
                        </td>
                    @endif
                </tr>
                @empty
                <tr><td colspan="13" style="text-align:center;padding:2.5rem;color:#999;"><i class="fa fa-arrow-up" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>Belum ada distribusi zakat</td></tr>
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
function rejectApproval(formId, inputId, label){Swal.fire({title:'Tolak ' + label + '?',input:'textarea',inputLabel:'Alasan penolakan',inputPlaceholder:'Wajib diisi...',showCancelButton:true,confirmButtonText:'Tolak',cancelButtonText:'Batal',confirmButtonColor:'#dc2626',inputValidator:(value)=>{if(!value || !value.trim()){return 'Alasan penolakan wajib diisi.';}}}).then((result)=>{if(result.isConfirmed){document.getElementById(inputId).value = result.value.trim();document.getElementById(formId).submit();}});}
</script>
@endsection
