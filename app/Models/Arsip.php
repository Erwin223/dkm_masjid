<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsips';
    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'jenis_surat',
        'tanggal_arsip',
        'file',
        'nama_file_asli'
    ];

    protected $casts = [
        'tanggal_arsip' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
