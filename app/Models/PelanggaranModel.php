<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pelanggaran';
    protected $fillable = [
        'id_pelanggaran',
        'id_santri',
        'id_kamar',
        'nama_pelanggaran',
        'point',
        'deskripsi_pelanggaran',
        'tanggal_pelanggaran'
    ];

    // public $sortable = [
    //     'nama_kelas'
    // ];
    protected $table = 'tb_pelanggaran';

    public function DataSantri()
    {
        return $this->belongsTo(DataSantriModel::class, 'id_santri');
    }

    public function Kamar()
    {
        return $this->belongsTo(KamarSantriModel::class, 'id_kamar');
    }

}
