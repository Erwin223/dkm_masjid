<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiZakat extends Model
{
    protected $table = 'distribusi_zakat';

    protected $fillable = [
        'tanggal',
        'mustahik_id',
        'jenis_zakat',
        'bentuk_zakat',
        'jumlah_zakat',
        'satuan',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_zakat' => 'decimal:2',
        'nominal' => 'decimal:2',
    ];

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_id');
    }

    public function getIsBarangAttribute()
    {
        return $this->bentuk_zakat === 'Barang';
    }

    public function getLabelJumlahAttribute()
    {
        if ($this->is_barang) {
            return $this->jumlah_utama . ' ' . $this->jumlah_unit;
        }

        return '-';
    }

    public function getJumlahUtamaAttribute()
    {
        if ($this->is_barang) {
            return $this->formatNumber($this->jumlah_zakat);
        }

        return '-';
    }

    public function getJumlahUnitAttribute()
    {
        if (! $this->is_barang) {
            return null;
        }

        $unit = trim((string) $this->satuan);
        return $unit !== '' ? $unit : 'unit';
    }

    public function getNilaiDanaAttribute()
    {
        return (float) ($this->nominal ?? ($this->is_barang ? 0 : $this->jumlah_zakat));
    }

    private function formatNumber($value)
    {
        $number = (float) $value;

        if (fmod($number, 1.0) === 0.0) {
            return number_format($number, 0, ',', '.');
        }

        $formatted = number_format($number, 2, ',', '.');
        return rtrim(rtrim($formatted, '0'), ',');
    }
}
