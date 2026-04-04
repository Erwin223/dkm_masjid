<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonasiKeluar extends Model
{
    protected $table = 'donasi_keluar';

    protected $fillable = [
        'tanggal',
        'jenis_donasi',
        'tujuan',
        'jumlah',
        'satuan',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
        'nominal' => 'decimal:2',
    ];

    public function getIsBarangAttribute()
    {
        return in_array($this->jenis_donasi, ['Barang', 'Makanan', 'Pakaian'], true);
    }

    public function getNilaiDanaAttribute()
    {
        return (float) ($this->is_barang ? ($this->nominal ?? 0) : ($this->jumlah ?? 0));
    }

    public function getLabelJumlahAttribute()
    {
        if (! $this->is_barang) {
            return 'Rp.' . number_format((float) $this->jumlah, 0, ',', '.');
        }

        return $this->formatNumber($this->jumlah) . ' ' . trim((string) $this->satuan);
    }

    private function formatNumber($value)
    {
        $formatted = number_format((float) $value, 2, ',', '.');
        return rtrim(rtrim($formatted, '0'), ',');
    }
}
