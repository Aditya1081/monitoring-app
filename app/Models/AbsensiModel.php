<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_absensi';
    protected $fillable = [
        'id_santri',
        'id_kamar',
        'jenis_absensi',
        'status_absensi',
        'tanggal_absensi',
    ];

    protected $table = 'tb_absensi';

    public function dataSantri()
    {
        return $this->belongsTo(DataSantriModel::class, 'id_santri');
    }

    public function kamarSantri()
    {
        return $this->belongsTo(KamarSantriModel::class, 'id_kamar');
    }
}

