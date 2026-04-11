@extends('layouts.admin')

@section('content')
@include('admin.arsip._styles')

<div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:24px;">
    <a href="{{ route('arsip.index') }}" class="btn-back">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>
    <span style="color:#d1d5db;font-size:18px;">|</span>
    <span style="font-size:13px;color:#9ca3af;">Edit Arsip</span>
</div>

<div class="form-box">
    <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Arsip</h3>

    @if($errors->any())
    <div class="error-list">
        <strong>Terjadi kesalahan:</strong>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('arsip.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul Arsip <span style="color:#ef4444;">*</span></label>
            <input type="text" id="judul" name="judul" value="{{ old('judul', $data->judul) }}" placeholder="e.g. Surat Keputusan Kepengurusan" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" placeholder="Keterangan tambahan tentang arsip..." rows="4">{{ old('deskripsi', $data->deskripsi) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="kategori">Kategori <span style="color:#ef4444;">*</span></label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori_list as $k)
                    <option value="{{ $k }}" {{ old('kategori', $data->kategori) == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_arsip">Tanggal Arsip <span style="color:#ef4444;">*</span></label>
                <input type="date" id="tanggal_arsip" name="tanggal_arsip" value="{{ old('tanggal_arsip', $data->tanggal_arsip->format('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="file">Upload File Baru (Opsional)</label>
            <input type="file" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png,.jpeg">
            <small style="color:#9ca3af;display:block;margin-top:6px;">Pilih salah satu: PDF, Word (DOC/DOCX), Excel (XLS/XLSX), Gambar (JPG/PNG/JPEG). Maksimal 5MB. Kosongkan jika tidak ingin mengubah file.</small>

            @if($data->file)
            <div class="preview" style="margin-top:12px;">
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:600;color:#333;">File Saat Ini</div>
                    <div style="font-size:12px;color:#6b7280;margin-top:4px;">
                        <i class="fa fa-file" style="margin-right:4px;"></i>
                        {{ $data->nama_file_asli }}
                    </div>
                </div>
                <a href="{{ route('arsip.download', $data->id) }}" class="btn-batal" style="margin:0;">
                    <i class="fa fa-download"></i> Download
                </a>
            </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-simpan">
                <i class="fa fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('arsip.index') }}" class="btn-batal">
                <i class="fa fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
