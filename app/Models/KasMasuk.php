<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    protected $table = 'kas_masuk';

    protected $fillable = [
        'tanggal',
        'sumber',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
    ];

    public function deletionRequest()
    {
        return $this->morphOne(DeletionRequest::class, 'model')->where('status', 'pending');
    }
}
