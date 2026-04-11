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
        'estimasi_anggaran',
        'keterangan',
        'kas_keluar_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'estimasi_anggaran' => 'decimal:2',
    ];

    public function kasKeluar()
    {
        return $this->belongsTo(KasKeluar::class, 'kas_keluar_id');
    }

    public function getRealisasiAnggaranAttribute(): float
    {
        return (float) ($this->kasKeluar->nominal ?? 0);
    }
}
