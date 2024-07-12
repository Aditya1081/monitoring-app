<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMadinModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kelas_madin';
    protected $fillable = [
        'nama_kelas_madin',
    ];

    protected $table = 'tb_kelas_madin';

    public function dataSantri()
    {
        return $this->hasMany(DataSantriModel::class, 'id_kelas_madin');
    }
}
