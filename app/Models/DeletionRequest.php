<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletionRequest extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'user_id',
        'status',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
