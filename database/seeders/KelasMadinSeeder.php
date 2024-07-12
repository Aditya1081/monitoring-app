<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasMadinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $kelasMadins = [
            ['nama_kelas_madin' => 'Ula'],
            ['nama_kelas_madin' => 'Wustho'],
            ['nama_kelas_madin' => 'Ulya'],
        ];

        DB::table('tb_kelas_madin')->insert($kelasMadins);
    }
}
