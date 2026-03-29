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
        'jumlah_zakat',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_zakat' => 'decimal:2',
    ];

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_id');
    }
}
