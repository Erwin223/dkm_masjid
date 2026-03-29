<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muzakki extends Model
{
    protected $table = 'muzakki';

    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
    ];

    public function penerimaanZakat()
    {
        return $this->hasMany(PenerimaanZakat::class, 'muzakki_id');
    }
}
