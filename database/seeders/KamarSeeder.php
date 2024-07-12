<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kamars = [
            ['nama_kamar' => 'Khumairah'],
            ['nama_kamar' => 'Huslun Najah'],
        ];

        DB::table('tb_kamar')->insert($kamars);
    }
}
