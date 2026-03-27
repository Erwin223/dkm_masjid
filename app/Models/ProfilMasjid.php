<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilMasjid extends Model
{
    protected $table = 'profil_masjid';

    protected $fillable = [
        'nama',
        'visi',
        'misi',
        'sejarah',
        'alamat',
    ];
}

