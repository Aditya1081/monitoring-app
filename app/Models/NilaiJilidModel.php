<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiJilidModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_nilai_jilid';
    protected $fillable = [
        'id_santri',
        'id_jilid',
        'keterangan_nilai',
        'halaman',
        'catatan',
        'tanggal_penilaian',
    ];

    protected $table = 'tb_nilai_jilid';

    public function dataSantri()
    {
        return $this->belongsTo(DataSantriModel::class, 'id_santri');
    }

    public function jilid()
    {
        return $this->belongsTo(JilidModel::class, 'id_jilid');
    }
}
