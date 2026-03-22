<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    protected $table = 'donatur';

    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'alamat',
        'jenis_donatur',
        'tanggal_daftar',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    // Relasi ke donasi masuk
    public function donasiMasuk()
    {
        return $this->hasMany(DonasiMasuk::class, 'donatur_id');
    }

    // Total donasi dari donatur ini
    public function totalDonasi()
    {
        return $this->donasiMasuk()->sum('total');
    }
}
