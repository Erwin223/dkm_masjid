<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasKeluar extends Model
{
    protected $table = 'kas_keluar';

    protected $fillable = [
        'tanggal',
        'jenis_pengeluaran',
        'nominal',
        'keterangan',
    ];

    public function kegiatan()
    {
        return $this->hasOne(JadwalKegiatan::class, 'kas_keluar_id');
    }
}
