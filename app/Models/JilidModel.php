<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JilidModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jilid';
    protected $fillable = [
        'nama_jilid',
    ];

    protected $table = 'tb_jilid';

    public function dataSantri()
    {
        return $this->hasMany(DataSantriModel::class, 'id_jilid');
    }
}
