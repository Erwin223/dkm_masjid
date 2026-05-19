@extends('layouts.admin')

@section('page-title', 'Persetujuan Ketua')

@section('content')

<style>
.approval-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.approval-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ecfccb, #bbf7d0);
    color: #166534;
}
.approval-title {
    margin: 0;
    font-size: 22px;
    color: #0f172a;
}
.approval-subtitle {
    margin: 4px 0 0;
    color: #64748b;
    font-size: 13px;
}
.summary-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 20px;
}
.summary-card,
.panel-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
}
.summary-card {
    padding: 18px;
}
.summary-label {
    font-size: 12px;
    color: #64748b;
    margin-bottom: 8px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
}
.summary-value {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}
.summary-note {
    margin-top: 8px;
    font-size: 12px;
    color: #94a3b8;
}
.panel-box {
    margin-bottom: 18px;
    overflow: hidden;
}
.panel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    border-bottom: 1px solid #e2e8f0;
}
.panel-title {
    margin: 0;
    font-size: 16px;
    color: #0f172a;
}
.count-pill {
    background: #f8fafc;
    color: #475569;
    border: 1px solid #e2e8f0;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.table-wrap {
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 12px 14px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 13px;
    vertical-align: top;
}
th {
    background: #f8fafc;
    color: #475569;
    text-align: left;
    font-weight: 700;
}
.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.module-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    background: #eff6ff;
    color: #1d4ed8;
}
.action-row {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}
.btn-approve,
.btn-reject {
    border: none;
    border-radius: 8px;
    padding: 7px 12px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
}
.btn-approve { background: #16a34a; }
.btn-reject { background: #dc2626; }
.empty-state {
    text-align: center;
    padding: 28px 16px;
    color: #94a3b8;
}
@media (max-width: 900px) {
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="approval-header">
    <div class="approval-icon">
        <i class="fa fa-clipboard-check"></i>
    </div>
    <div>
        <h1 class="approval-title">Persetujuan Ketua</h1>
        <p class="approval-subtitle">Pusat approval untuk data yang menunggu persetujuan dan permintaan hapus.</p>
    </div>
</div>

<div class="summary-grid">
    <div class="summary-card">
        <div class="summary-label">Total Pending</div>
        <div class="summary-value">{{ $pendingApprovalCount + $pendingDeletionCount }}</div>
        <div class="summary-note">Semua item yang masih membutuhkan aksi ketua</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Pending Approval</div>
        <div class="summary-value" style="color:#2563eb;">{{ $pendingApprovalCount }}</div>
        <div class="summary-note">Kas keluar dan jadwal kegiatan yang belum diputuskan</div>
    </div>
    <div class="summary-card">
        <div class="summary-label">Pending Hapus</div>
        <div class="summary-value" style="color:#ea580c;">{{ $pendingDeletionCount }}</div>
        <div class="summary-note">Permintaan penghapusan data dari admin</div>
    </div>
</div>

<div class="panel-box">
    <div class="panel-head">
        <h2 class="panel-title"><i class="fa fa-arrow-up" style="color:#ea580c;"></i> Approval Kas Keluar</h2>
        <span class="count-pill">{{ $pendingKasKeluar->count() }} pending</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Pengeluaran</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingKasKeluar as $i => $kas)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ optional($kas->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $kas->jenis_pengeluaran }}</td>
                    <td><strong>Rp.{{ number_format($kas->nominal, 0, ',', '.') }}</strong></td>
                    <td>{{ $kas->keterangan ?: '-' }}</td>
                    <td>
                        <div class="action-row">
                            <form action="{{ route('kas.keluar.approve', $kas->id) }}" method="POST">
                                @csrf
                                <button class="btn-approve" type="submit" onclick="return confirm('Approve kas keluar ini? Saldo utama akan langsung terpotong.')">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            </form>
                            <form id="reject-kas-{{ $kas->id }}" action="{{ route('kas.keluar.reject', $kas->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="rejection_reason" id="reject-kas-reason-{{ $kas->id }}">
                                <button class="btn-reject" type="button" onclick="rejectApproval('reject-kas-{{ $kas->id }}', 'reject-kas-reason-{{ $kas->id }}', 'kas keluar ini')">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">Tidak ada kas keluar yang menunggu approval.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="panel-box">
    <div class="panel-head">
        <h2 class="panel-title"><i class="fa fa-calendar-check" style="color:#0f8b6d;"></i> Approval Jadwal Kegiatan</h2>
        <span class="count-pill">{{ $pendingKegiatan->count() }} pending</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Penanggung Jawab</th>
                    <th>Estimasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingKegiatan as $i => $kegiatan)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $kegiatan->nama_kegiatan }}</td>
                    <td>{{ optional($kegiatan->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $kegiatan->tempat ?: '-' }}</td>
                    <td>{{ $kegiatan->penanggung_jawab ?: '-' }}</td>
                    <td>
                        @if($kegiatan->estimasi_anggaran)
                            Rp.{{ number_format($kegiatan->estimasi_anggaran, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="action-row">
                            <form action="{{ route('kegiatan.jadwal.approve', $kegiatan->id) }}" method="POST">
                                @csrf
                                <button class="btn-approve" type="submit" onclick="return confirm('Approve kegiatan ini agar tampil di website?')">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                            </form>
                            <form id="reject-kegiatan-{{ $kegiatan->id }}" action="{{ route('kegiatan.jadwal.reject', $kegiatan->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="rejection_reason" id="reject-kegiatan-reason-{{ $kegiatan->id }}">
                                <button class="btn-reject" type="button" onclick="rejectApproval('reject-kegiatan-{{ $kegiatan->id }}', 'reject-kegiatan-reason-{{ $kegiatan->id }}', 'jadwal kegiatan ini')">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">Tidak ada jadwal kegiatan yang menunggu approval.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="panel-box">
    <div class="panel-head">
        <h2 class="panel-title"><i class="fa fa-trash-can" style="color:#dc2626;"></i> Persetujuan Hapus Data</h2>
        <span class="count-pill">{{ $requests->count() }} pending</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Request</th>
                    <th>Admin Peminta</th>
                    <th>Modul</th>
                    <th>Detail Data</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $i => $req)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $req->created_at->translatedFormat('d M Y, H:i') }}</td>
                    <td>{{ $req->user->name ?? 'Unknown' }}</td>
                    <td>
                        @php
                            $moduleLabel = match ($req->model_type) {
                                'App\Models\KasMasuk' => 'Kas Masuk',
                                'App\Models\KasKeluar' => 'Kas Keluar',
                                'App\Models\JadwalKegiatan' => 'Jadwal Kegiatan',
                                'App\Models\DonasiMasuk' => 'Donasi Masuk',
                                'App\Models\DonasiKeluar' => 'Donasi Keluar',
                                'App\Models\PenerimaanZakat' => 'Penerimaan Zakat',
                                'App\Models\DistribusiZakat' => 'Distribusi Zakat',
                                default => class_basename($req->model_type),
                            };
                        @endphp
                        <span class="module-badge">{{ $moduleLabel }}</span>
                    </td>
                    <td>
                        @if($req->model)
                            @if($req->model_type === 'App\Models\KasMasuk')
                                Rp.{{ number_format($req->model->jumlah, 0, ',', '.') }} ({{ $req->model->sumber }})
                            @elseif($req->model_type === 'App\Models\KasKeluar')
                                Rp.{{ number_format($req->model->nominal, 0, ',', '.') }} ({{ $req->model->jenis_pengeluaran }})
                            @elseif($req->model_type === 'App\Models\JadwalKegiatan')
                                {{ $req->model->nama_kegiatan }} - {{ optional($req->model->tanggal)->translatedFormat('d M Y') }}
                            @elseif(isset($req->model->nama))
                                {{ $req->model->nama }}
                            @elseif(isset($req->model->judul))
                                {{ $req->model->judul }}
                            @else
                                ID: {{ $req->model_id }}
                            @endif
                        @else
                            <span style="color:#dc2626;">Data asli sudah tidak ada</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-row">
                            <form action="{{ route('admin.deletion_approvals.approve', $req->id) }}" method="POST">
                                @csrf
                                <button class="btn-approve" type="submit" onclick="return confirm('Yakin setujui penghapusan data ini?')">
                                    <i class="fa fa-check"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.deletion_approvals.reject', $req->id) }}" method="POST">
                                @csrf
                                <button class="btn-reject" type="submit" onclick="return confirm('Yakin tolak penghapusan data ini?')">
                                    <i class="fa fa-times"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">Tidak ada permintaan hapus yang menunggu persetujuan.</td>
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
@if(session('error'))
<script>Swal.fire({ icon:'error', title:'Error!', text:'{{ session("error") }}' });</script>
@endif
<script>
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
