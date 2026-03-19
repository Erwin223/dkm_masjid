<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    protected $table = 'jadwal_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'waktu',
        'tempat',
        'penanggung_jawab',
        'keterangan',
        'kas_keluar_id',
    ];

    public function kasKeluar()
    {
        return $this->belongsTo(KasKeluar::class, 'kas_keluar_id');
    }
}
