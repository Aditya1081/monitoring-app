<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapels = [
            ['nama_mapel_madin' => 'Quran Hadist'],
            ['nama_mapel_madin' => 'Akidah Akhlak'],
            ['nama_mapel_madin' => 'Fiqih'],
            ['nama_mapel_madin' => 'Sejarah Islam'],
            ['nama_mapel_madin' => 'Bahasa Arab'],
        ];

        DB::table('tb_mapel_madin')->insert($mapels);
    }
}
