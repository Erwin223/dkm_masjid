<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalImam extends Model
{
    protected $table = 'jadwal_imams';

    protected $fillable = [
        'imam_id',
        'tanggal',
        'hari',
        'waktu_sholat',
        'keterangan',
    ];

    public function imam()
    {
        return $this->belongsTo(DataImam::class, 'imam_id');
    }
}
