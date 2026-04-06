<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property bool $is_barang
 * @property float $nilai_dana
 * @property string $label_jumlah
 */
class DonasiMasuk extends Model
{
    protected $table = 'donasi_masuk';

    protected $fillable = [
        'donatur_id',
        'donatur_nama',
        'tanggal',
        'jenis_donasi',
        'kategori_donasi',
        'jumlah',
        'satuan',
        'total',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
        'total'   => 'decimal:2',
    ];

    public function getIsBarangAttribute()
    {
        return in_array($this->jenis_donasi, ['Barang', 'Makanan', 'Pakaian'], true);
    }

    public function getNilaiDanaAttribute()
    {
        return (float) ($this->total ?? 0);
    }

    public function getLabelJumlahAttribute()
    {
        if ($this->is_barang) {
            return $this->formatNumber($this->jumlah) . ' ' . trim((string) $this->satuan);
        }

        return 'Rp.' . number_format((float) $this->jumlah, 0, ',', '.');
    }

    // Relasi ke donatur
    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'donatur_id');
    }

    // Nama tampil: dari relasi atau fallback donatur_nama
    public function getNamaDonaturAttribute()
    {
        return $this->donatur ? $this->donatur->nama : ($this->donatur_nama ?? 'Hamba Allah');
    }

    private function formatNumber($value)
    {
        $formatted = number_format((float) $value, 2, ',', '.');
        return rtrim(rtrim($formatted, '0'), ',');
    }
}
