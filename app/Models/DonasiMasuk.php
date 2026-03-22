<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'total',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
        'total'   => 'decimal:2',
    ];

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
}
