<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mustahik extends Model
{
    protected $table = 'mustahik';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'kategori_mustahik',
        'keterangan',
    ];

    public function distribusiZakat()
    {
        return $this->hasMany(DistribusiZakat::class, 'mustahik_id');
    }
}
