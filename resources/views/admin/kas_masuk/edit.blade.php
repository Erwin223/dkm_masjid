@extends('layouts.admin')

@section('content')

@include('admin.kas_masuk._styles')
    <div class="form-box">
        <h3><i class="fa fa-edit" style="color:#0f8b6d;"></i> Edit Kas Masuk</h3>

        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('kas.masuk.update', $data->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal <span style="color:red;">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $data->tanggal) }}" required>
                </div>

                <div class="form-group">
                    <label>Sumber <span style="color:red;">*</span></label>
                    <select name="sumber" class="form-control" required>
                        <option value="" disabled>-- Pilih Sumber --</option>
                        <option value="Infaq Langsung" {{ old('sumber', $data->sumber) == 'Infaq Langsung' ? 'selected' : '' }}>
                            Infaq Langsung
                        </option>
                        <option value="Transfer" {{ old('sumber', $data->sumber) == 'Transfer' ? 'selected' : '' }}>
                            Transfer
                        </option>
                        <option value="Donasi" {{ old('sumber', $data->sumber) == 'Donasi' ? 'selected' : '' }}>
                            Donasi
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Jumlah (Rp) <span style="color:red;">*</span></label>
                <div style="position:relative;">
                    <span
                        style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#999;font-size:13px;pointer-events:none;">Rp</span>
                    <input type="text" name="jumlah" value="{{ old('jumlah', number_format($data->jumlah, 0, ',', '.')) }}"
                        onkeyup="formatRupiah(this)" required style="padding-left:32px;">
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan">{{ old('keterangan', $data->keterangan) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-simpan"><i class="fa fa-save"></i> Update Data</button>
                <a href="{{ route('kas.masuk.index') }}" class="btn-batal"><i class="fa fa-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>

    <script>
        function formatRupiah(el) {
            let angka = el.value.replace(/[^0-9]/g, '');
            el.value = new Intl.NumberFormat('id-ID').format(angka);
        }
    </script>

@endsection