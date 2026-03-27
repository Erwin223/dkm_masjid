<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'tanggal',
        'gambar',
        'judul',
        'deskripsi',
    ];
}
