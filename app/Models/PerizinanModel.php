<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerizinanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_perizinan';
    protected $primaryKey = 'id_perizinan';
    protected $fillable = [
        'id_perizinan',
        'id_santri',
        'id_kamar',
        'nama_perizinan',
        'tanggal_mulai',
        'tanggal_akhir',
        'deskripsi_perizinan',
        'deskripsi_pengurus',
        'status_perizinan'
    ];

    // public $sortable = [
    //     'nama_kelas'
    // ];

    public function DataSantri()
    {
        return $this->belongsTo(DataSantriModel::class, 'id_santri');
    }

    public function Kamar()
    {
        return $this->belongsTo(KamarSantriModel::class, 'id_kamar');
    }

}
