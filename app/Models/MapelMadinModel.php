<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelMadinModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_mapel_madin';
    protected $fillable = [
        'nama_mapel_madin',
    ];

    protected $table = 'tb_mapel_madin';

    public function nilaiMadin()
    {
        return $this->hasMany(NilaiMadinModel::class, 'id_mapel_madin');
    }
}
