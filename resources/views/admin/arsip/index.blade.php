@extends('layouts.admin')

@section('content')
@include('admin.arsip._styles')

<div class="arsip-header">
    <div class="arsip-title">
        <div class="arsip-icon"><i class="fa fa-folder" style="color:#0f6e56;font-size:15px;"></i></div>
        Kelola Arsip dan Dokumen
    </div>
</div>
    {{-- ② SUMMARY CARDS ─────────────────────────── --}}
    <div class="arsip-summary-row">
        @php
            $total_surat = $data->where('kategori', 'Surat')->count();
            $total_surat_masuk = $data->where('kategori', 'Surat')->where('jenis_surat', 'masuk')->count();
            $total_surat_keluar = $data->where('kategori', 'Surat')->where('jenis_surat', 'keluar')->count();
            $total_dokumen = $data->where('kategori', 'Dokumen')->count();
            $total_laporan = $data->where('kategori', 'Laporan')->count();
        @endphp
        <div class="arsip-stat-card">
            <div class="arsip-stat-icon" style="background:#d1fae5;color:#065f46;"><i class="fa fa-arrow-left"></i></div>
            <div class="arsip-stat-body">
                <div class="arsip-stat-label">Surat Masuk</div>
                <div class="arsip-stat-value">{{ $total_surat_masuk }} item</div>
                <div class="arsip-stat-sub">Surat yang diterima</div>
            </div>
        </div>
        <div class="arsip-stat-card">
            <div class="arsip-stat-icon" style="background:#d1fae5;color:#065f46;"><i class="fa fa-arrow-right"></i></div>
            <div class="arsip-stat-body">
                <div class="arsip-stat-label">Surat Keluar</div>
                <div class="arsip-stat-value">{{ $total_surat_keluar }} item</div>
                <div class="arsip-stat-sub">Surat yang dikirim</div>
            </div>
        </div>
        <div class="arsip-stat-card">
            <div class="arsip-stat-icon" style="background:#dbeafe;color:#1e40af;"><i class="fa fa-file-alt"></i></div>
            <div class="arsip-stat-body">
                <div class="arsip-stat-label">Total Dokumen</div>
                <div class="arsip-stat-value">{{ $total_dokumen }} item</div>
                <div class="arsip-stat-sub">Dokumen penting</div>
            </div>
        </div>
    </div>

    {{-- ③ TABLE BOX ──────────────────────────────── --}}
    <div class="arsip-table-box">
        <div class="arsip-table-top">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <h3 style="margin:0;font-size:16px;"><i class="fa fa-folder-open" style="color:#0f8b6d;margin-right:8px;"></i>Daftar Arsip</h3>
                <span style="font-size:12px;color:#085041;background:#e1f5ee;padding:4px 12px;border-radius:20px;font-weight:500;" id="arsipBadge">{{ count($data) }} data</span>
            </div>
            
            <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <label for="filterKategori" style="font-weight:600;color:#374151;font-size:14px;">Filter Kategori:</label>
                    <select id="filterKategori" style="padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;cursor:pointer;background:#fff;" onchange="filterByKategori()">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Surat">Surat</option>
                        <option value="Dokumen">Dokumen</option>
                        <option value="Laporan">Laporan</option>
                        <option value="Kontrak">Kontrak</option>
                        <option value="Proposal">Proposal</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div id="filterJenisSuratDiv" style="display:none;gap:8px;align-items:center;">
                    <label for="filterJenisSurat" style="font-weight:600;color:#374151;font-size:14px;">Jenis Surat:</label>
                    <select id="filterJenisSurat" style="padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;cursor:pointer;background:#fff;" onchange="arsipFilter()">
                        <option value="">-- Semua Jenis --</option>
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                </div>
            </div>
            
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <input class="arsip-search-input" type="text" id="arsipSearch" placeholder="Cari judul / deskripsi..." onkeyup="arsipFilter()">
                <a href="{{ route('arsip.create') }}" class="arsip-btn-tambah">
                    <i class="fa fa-plus"></i> Tambah Arsip
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="arsip-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Tanggal Arsip</th>
                        <th>File</th>
                        <th style="text-align:center;width:60px;">Download</th>
                        <th style="text-align:center;width:60px;">Edit</th>
                        <th style="text-align:center;width:60px;">Hapus</th>
                    </tr>
                </thead>
                <tbody id="arsipTableBody">
                    @forelse($data as $i => $arsip)
                    <tr data-jenis="{{ $arsip->jenis_surat ?? '' }}" data-kategori="{{ $arsip->kategori }}">
                        <td style="font-weight:600;color:#6b7280;width:40px;">{{ $i + 1 }}</td>
                        <td>
                            <div class="arsip-judul">{{ $arsip->judul }}</div>
                            <div class="arsip-deskripsi">{{ Str::limit($arsip->deskripsi, 50) }}</div>
                        </td>
                        <td>
                            <span class="arsip-badge arsip-badge-{{ strtolower(str_replace(' ', '-', $arsip->kategori)) }}">
                                {{ $arsip->kategori }}
                            </span>
                        </td>
                        <td>
                            @if($arsip->kategori === 'Surat' && $arsip->jenis_surat)
                                @if($arsip->jenis_surat === 'masuk')
                                <span class="arsip-badge" style="background:#d1fae5;color:#065f46;">
                                    <i class="fa fa-arrow-left"></i> Masuk
                                </span>
                                @else
                                <span class="arsip-badge" style="background:#d1fae5;color:#065f46;">
                                    <i class="fa fa-arrow-right"></i> Keluar
                                </span>
                                @endif
                            @else
                            <span style="color:#9ca3af;font-size:12px;">-</span>
                            @endif
                        </td>
                        <td>
                            <span style="color:#6b7280;font-size:13px;">
                                {{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->translatedFormat('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <span style="color:#6b7280;font-size:12px;">
                                <i class="fa fa-file-pdf" style="color:#ef4444;margin-right:4px;"></i>
                                {{ Str::limit($arsip->nama_file_asli, 30) }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('arsip.download', $arsip->id) }}" class="arsip-btn-action-cell arsip-btn-download" title="Download">
                                <i class="fa fa-download"></i>
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('arsip.edit', $arsip->id) }}" class="arsip-btn-action-cell arsip-btn-edit" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <form id="del-arsip-{{ $arsip->id }}" action="{{ route('arsip.delete', $arsip->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="button" onclick="hapusArsip('del-arsip-{{ $arsip->id }}')" class="arsip-btn-action-cell arsip-btn-delete" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:3rem;color:#999;">
                            <i class="fa fa-inbox" style="font-size:28px;display:block;margin-bottom:12px;color:#ccc;"></i>
                            <div style="font-size:14px;color:#6b7280;">Belum ada arsip data</div>
                            <a href="{{ route('arsip.create') }}" class="arsip-btn-tambah" style="margin-top:16px;display:inline-block;">
                                <i class="fa fa-plus"></i> Tambah Arsip Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($data))
        <div style="margin-top:16px;display:flex;justify-content:flex-end;font-size:12px;color:#6b7280;">
            <strong>Total: {{ count($data) }} data arsip</strong>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session("success") }}', timer:2000, showConfirmButton:false });</script>
@endif
<script>
// Initialize filter on page load
document.addEventListener('DOMContentLoaded', function() {
    const jenisSuratDiv = document.getElementById('filterJenisSuratDiv');
    if (jenisSuratDiv) {
        jenisSuratDiv.style.display = 'none';
    }
});

function filterByKategori() {
    const kategori = document.getElementById('filterKategori').value;
    const jenisSuratDiv = document.getElementById('filterJenisSuratDiv');
    const jenisSuratSelect = document.getElementById('filterJenisSurat');
    
    // Tampilkan dropdown jenis surat hanya jika kategori = "Surat"
    if (kategori === 'Surat') {
        jenisSuratDiv.style.display = 'flex';
    } else {
        jenisSuratDiv.style.display = 'none';
        jenisSuratSelect.value = ''; // Reset jenis surat filter
    }
    
    // Apply filter
    arsipFilter();
}

function arsipFilter() {
    const q = document.getElementById('arsipSearch').value.toLowerCase();
    const filterKategori = document.getElementById('filterKategori').value;
    const filterJenisSurat = document.getElementById('filterJenisSurat').value;
    const rows = document.querySelectorAll('#arsipTableBody tr');
    
    let v = 0;
    
    rows.forEach(r => {
        let kategori = r.getAttribute('data-kategori');
        let jenis = r.getAttribute('data-jenis');
        let text = r.textContent.toLowerCase();
        
        // Check kategori filter
        let matchKategori = !filterKategori || kategori === filterKategori;
        
        // Check jenis surat filter (only applies if kategori = Surat)
        let matchJenis = true;
        if (filterKategori === 'Surat' && filterJenisSurat) {
            matchJenis = jenis === filterJenisSurat;
        } else if (!filterKategori && filterJenisSurat) {
            // Jika pilih jenis surat tapi kategori tidak di-filter, hanya filter jenis
            matchJenis = jenis === filterJenisSurat;
        }
        
        // Check search text
        let matchText = q === '' || text.includes(q);
        
        // Show row if all conditions match
        if (matchKategori && matchJenis && matchText) {
            r.style.display = '';
            v++;
        } else {
            r.style.display = 'none';
        }
    });
    
    document.getElementById('arsipBadge').textContent = v + ' data';
}

function hapusArsip(formId){
    Swal.fire({
        title: 'Yakin hapus?',
        text: 'Data arsip dan file tidak bisa dikembalikan!',
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
