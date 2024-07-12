<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSantriModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_santri';
    protected $fillable = [
        'id_kamar',
        'id_kelas',
        'nama_santri',
        'NIS',
        'NISN',
        'NIK',
        'kota_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telp_wali',
        'nama_wali_santri',
        'no_va',
        'id_kelas_madin',
        'id_jilid',
    ];

    protected $table = 'tb_data_santri';

    public function kamarSantri()
    {
        return $this->belongsTo(KamarSantriModel::class, 'id_kamar');
    }

    public function kelasSantri()
    {
        return $this->belongsTo(ParalelModel::class, 'id_kelas');
    }

    public function madinSantri()
    {
        return $this->belongsTo(KelasMadinModel::class, 'id_kelas_madin');
    }

    public function jilidSantri()
    {
        return $this->belongsTo(JilidModel::class, 'id_jilid');
    }

    public function pelanggarans()
    {
        return $this->hasMany(PelanggaranModel::class, 'id_santri');
    }

    public function absensi()
    {
        return $this->hasMany(AbsensiModel::class, 'id_santri');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($santri) {
            $santri->pelanggarans()->delete();
            $santri->absensi()->delete();
        });
    }
}
