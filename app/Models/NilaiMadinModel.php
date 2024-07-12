<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMadinModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nilai_madin';
    protected $fillable = [
        'id_santri',
        'id_kelas_madin',
        'id_mapel_madin',
        'nilai',
        'catatan',
        'tanggal_penilaian',
    ];

    protected $table = 'tb_nilai_madin';

    public function dataSantri()
    {
        return $this->belongsTo(DataSantriModel::class, 'id_santri');
    }

    public function kelasMadin()
    {
        return $this->belongsTo(KelasMadinModel::class, 'id_kelas_madin');
    }

    public function mapelMadin()
    {
        return $this->belongsTo(MapelMadinModel::class, 'id_mapel_madin');
    }

}
