<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class KamarSantriModel extends Model
// {
//     use HasFactory;
//     // use Sortable;

//     protected $primaryKey = 'id_kamar';
//     protected $fillable = [
//         'nama_kamar',
//     ];

//     // public $sortable = [
//     //     'nama_kelas'
//     // ];
//     protected $table = 'tb_kamar';

//     public function DataSantri(){
//         return $this->hasMany(DataSantri::class);
//     }

// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarSantriModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kamar';
    protected $fillable = [
        'nama_kamar',
    ];

    protected $table = 'tb_kamar';

    public function dataSantri()
    {
        return $this->hasMany(DataSantriModel::class, 'id_kamar');
    }

}

