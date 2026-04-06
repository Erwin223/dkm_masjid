<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_barang
 * @property float $nilai_dana
 * @property string $label_jumlah
 * @property bool $is_fitrah_uang
 */
class PenerimaanZakat extends Model
{
    protected $table = 'penerimaan_zakat';

    protected $fillable = [
        'muzakki_id',
        'tanggal',
        'jenis_zakat',
        'bentuk_zakat',
        'jumlah_zakat',
        'satuan',
        'nominal',
        'nominal_pembagian',
        'harga_barang_fitrah',
        'jumlah_tanggungan',
        'standar_per_jiwa',
        'metode_pembayaran',
        'keterangan',
        'status',
        'created_by',
        'updated_by',
        'verified_date',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_zakat' => 'decimal:2',
        'nominal' => 'decimal:2',
        'nominal_pembagian' => 'decimal:2',
        'harga_barang_fitrah' => 'decimal:2',
        'jumlah_tanggungan' => 'integer',
        'standar_per_jiwa' => 'decimal:2',
        'verified_date' => 'datetime',
    ];

    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class, 'muzakki_id');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function distribusiZakat()
    {
        return $this->hasMany(DistribusiZakat::class, 'penerimaan_zakat_id');
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

    public function getIsFitrahUangAttribute()
    {
        return str_contains(strtolower((string) $this->jenis_zakat), 'fitrah')
            && $this->bentuk_zakat === 'Uang';
    }

    public function getLabelPembagianAttribute()
    {
        if (! $this->is_fitrah_uang || ! $this->nominal_pembagian) {
            return '-';
        }

        return 'Rp ' . number_format((float) $this->nominal_pembagian, 0, ',', '.') . ' / jiwa';
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
