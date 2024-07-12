<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestasiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_prestasi';
    protected $primaryKey = 'id_prestasi';
    protected $fillable = ['id_kamar', 'id_santri','nama_prestasi', 'slug_prestasi', 'deskripsi','tanggal_prestasi', 'file_prestasi'];


    public function Kamar()
    {
        return $this->belongsTo(KamarSantriModel::class, 'id_kamar');
    }

    public function dataSantri()
    {
        return $this->belongsTo(DataSantriModel::class, 'id_santri');
    }

}

