<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParalelModel extends Model
{
    use HasFactory;
    // use Sortable;

    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'nama_kelas',
    ];

    // public $sortable = [
    //     'nama_kelas'
    // ];
    protected $table = 'tb_kelas';

    public function DataSantri(){
        return $this->hasMany(DataSantri::class);
    }

    public function kelas()
    {
        return $this->belongsTo(ParalelModel::class, 'id_kelas');
    }
}
