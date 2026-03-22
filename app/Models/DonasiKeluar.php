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
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];
}
