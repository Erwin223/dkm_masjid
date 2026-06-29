<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'tanggal',
        'penulis',
        'gambar',
        'judul',
        'sinopsis',
        'isi_berita',
    ];

    protected $casts = [
        'gambar' => 'array',
    ];
}

