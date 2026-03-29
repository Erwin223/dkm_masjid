<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanZakat extends Model
{
    protected $table = 'penerimaan_zakat';

    protected $fillable = [
        'muzakki_id',
        'tanggal',
        'jenis_zakat',
        'jumlah_zakat',
        'jumlah_tanggungan',
        'metode_pembayaran',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_zakat' => 'decimal:2',
        'jumlah_tanggungan' => 'integer',
    ];

    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class, 'muzakki_id');
    }
}
