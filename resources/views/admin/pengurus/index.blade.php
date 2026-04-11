@extends('layouts.admin')

@section('content')
@include('admin.pengurus._styles')

<div class="pengurus-header">
    <div class="pengurus-title">
        <div class="pengurus-icon"><i class="fa fa-users" style="color:#0f6e56;font-size:15px;"></i></div>
        Kelola Pengurus Masjid
    </div>
</div>
<div class="pgr-page">
    <div class="pgr-summary-row">
        <div class="pgr-stat-card">
            <div class="pgr-stat-icon" style="background:#d1fae5;color:#065f46;"><i class="fa fa-users"></i></div>
            <div class="pgr-stat-body">
                <div class="pgr-stat-label">Total Anggota</div>
                <div class="pgr-stat-value">{{ count($data) }} orang</div>
                <div class="pgr-stat-sub">Seluruh pengurus aktif</div>
            </div>
        </div>
        <div class="pgr-stat-card">
            <div class="pgr-stat-icon" style="background:#dbeafe;color:#1e40af;"><i class="fa fa-user-tie"></i></div>
            <div class="pgr-stat-body">
                <div class="pgr-stat-label">Pengurus Inti</div>
                <div class="pgr-stat-value">{{ $data->whereIn('jabatan', ['Ketua', 'Sekretaris'])->count() }} orang</div>
                <div class="pgr-stat-sub">Pimpinan struktural</div>
            </div>
        </div>
        <div class="pgr-stat-card">
            <div class="pgr-stat-icon" style="background:#fef3c7;color:#92400e;"><i class="fa fa-users-gear"></i></div>
            <div class="pgr-stat-body">
                <div class="pgr-stat-label">Anggota Lainnya</div>
                <div class="pgr-stat-value">{{ $data->whereNotIn('jabatan', ['Ketua', 'Sekretaris'])->count() }} orang</div>
                <div class="pgr-stat-sub">Anggota biasa</div>
            </div>
        </div>
    </div>

    {{-- ③ TABLE BOX ──────────────────────────────────── --}}
    <div class="pgr-table-box">
        <div class="pgr-table-top">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <h3 style="margin:0;font-size:16px;"><i class="fa fa-address-card" style="color:#0f8b6d;margin-right:8px;"></i>Daftar Pengurus</h3>
                <span style="font-size:12px;color:#085041;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="pgrBadge">{{ count($data) }} data</span>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <input class="pgr-search-input" type="text" id="pgrSearch" placeholder="Cari nama / jabatan..." onkeyup="pgrFilter()">
                <a href="{{ route('pengurus.create') }}" class="pgr-btn-tambah">
                    <i class="fa fa-plus"></i> Tambah Pengurus
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="pgr-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>No. HP</th>
                        <th style="text-align:center;width:40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="pgrTableBody">
                    @forelse($data as $i => $p)
                    <tr>
                        <td style="font-weight:600;color:#6b7280;width:40px;">{{ $i + 1 }}</td>
                        <td>
                            @if($p->foto)
                                <img src="{{ asset('storage/'.$p->foto) }}" class="pgr-avatar">
                            @else
                                <div class="pgr-avatar-initials">{{ strtoupper(substr($p->nama, 0, 2)) }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="pgr-nama">{{ $p->nama }}</div>
                            <div class="pgr-id">#{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td>
                            <span class="pgr-jabatan-badge">{{ $p->jabatan }}</span>
                        </td>
                        <td>
                            <i class="fa fa-phone" style="color:#aaa;font-size:12px;margin-right:6px;"></i>
                            <span style="color:#555;">{{ $p->no_hp ?? '-' }}</span>
                        </td>
                        <td style="text-align:center;">
                            <div class="pgr-action-group">
                                <a href="{{ route('pengurus.edit', $p->id) }}" class="pgr-btn-action pgr-btn-edit" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form id="del-pgr-{{ $p->id }}" action="{{ route('pengurus.delete', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="hapusPengurus('del-pgr-{{ $p->id }}')" class="pgr-btn-action pgr-btn-delete" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:3rem;color:#999;">
                            <i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:12px;color:#ccc;"></i>
                            <div style="font-size:14px;color:#6b7280;">Belum ada data pengurus</div>
                            <a href="{{ route('pengurus.create') }}" class="pgr-btn-tambah" style="margin-top:16px;display:inline-block;">
                                <i class="fa fa-plus"></i> Tambah Pengurus Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($data))
        <div style="margin-top:16px;display:flex;justify-content:flex-end;font-size:12px;color:#6b7280;">
            <strong>Total: {{ count($data) }} data pengurus</strong>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif
<script>
function pgrFilter(){
    const q = document.getElementById('pgrSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#pgrTableBody tr');
    let v = 0;
    rows.forEach(r => {
        if(r.textContent.toLowerCase().includes(q)){ r.style.display=''; v++; }
        else r.style.display='none';
    });
    document.getElementById('pgrBadge').textContent = v + ' data';
}

function hapusPengurus(formId){
    Swal.fire({
        title: 'Yakin hapus?',
        text: 'Data pengurus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0f8b6d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed) document.getElementById(formId).submit();
    });
}
</script>

@endsection
