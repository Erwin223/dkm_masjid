@extends('layouts.admin')

@section('content')

<style>
.header-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    background: #fff;
    padding: 15px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}
.header-box h2 {
    margin: 0;
    font-size: 18px;
    color: #333;
}
.table-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}
table {
    width: 100%;
    border-collapse: collapse;
}
th {
    background: #f8fafc;
    padding: 12px;
    text-align: left;
    font-size: 14px;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
}
td {
    padding: 12px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 14px;
    color: #334155;
}
.btn-approve {
    background: #10b981;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
}
.btn-reject {
    background: #ef4444;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
}
.module-badge {
    background: #e0e7ff;
    color: #4338ca;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}
</style>

<div class="header-box">
    <h2><i class="fa fa-check-circle" style="color:#ef4444;"></i> Persetujuan Hapus Data</h2>
</div>

<div class="table-box">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal Request</th>
                    <th>Admin Peminta</th>
                    <th>Modul Data</th>
                    <th>Detail Data</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $i => $req)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $req->created_at->translatedFormat('d M Y, H:i') }}</td>
                    <td>{{ $req->user->name ?? 'Unknown' }}</td>
                    <td>
                        @if($req->model_type == 'App\Models\KasMasuk')
                            <span class="module-badge" style="background:#dcfce7; color:#166534;">Kas Masuk</span>
                        @elseif($req->model_type == 'App\Models\KasKeluar')
                            <span class="module-badge" style="background:#ffedd5; color:#c2410c;">Kas Keluar</span>
                        @else
                            <span class="module-badge">{{ class_basename($req->model_type) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($req->model)
                            @if($req->model_type == 'App\Models\KasMasuk')
                                Rp.{{ number_format($req->model->jumlah, 0, ',', '.') }} ({{ $req->model->sumber }})
                            @elseif($req->model_type == 'App\Models\KasKeluar')
                                Rp.{{ number_format($req->model->nominal, 0, ',', '.') }} ({{ $req->model->jenis_pengeluaran }})
                            @else
                                ID: {{ $req->model_id }}
                            @endif
                        @else
                            <span style="color:#ef4444;">Data asli sudah tidak ada</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <div style="display:flex; justify-content:center; gap:8px;">
                            <form action="{{ route('admin.deletion_approvals.approve', $req->id) }}" method="POST">
                                @csrf
                                <button class="btn-approve" type="submit" onclick="return confirm('Yakin setujui penghapusan data ini?')"><i class="fa fa-check"></i> Setujui</button>
                            </form>
                            <form action="{{ route('admin.deletion_approvals.reject', $req->id) }}" method="POST">
                                @csrf
                                <button class="btn-reject" type="submit" onclick="return confirm('Yakin tolak penghapusan data ini?')"><i class="fa fa-times"></i> Tolak</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:#999;">
                        <i class="fa fa-inbox" style="font-size:26px;display:block;margin-bottom:8px;color:#ccc;"></i>
                        Tidak ada permintaan penghapusan.
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
@if(session('error'))
<script>Swal.fire({ icon:'error', title:'Error!', text:'{{ session("error") }}' });</script>
@endif

@endsection
