<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataImam extends Model
{
    protected $table = 'data_imam';
    protected $fillable = ['nama','alamat','no_hp','status','keterangan'];

    public function jadwal()
    {
        return $this->hasMany(JadwalImam::class, 'imam_id');
    }
}
