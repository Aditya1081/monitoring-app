<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $paralels = [
            ['nama_kelas' => '7A'],
            ['nama_kelas' => '8A'],
            ['nama_kelas' => '9A'],
            ['nama_kelas' => '10A'],
            ['nama_kelas' => '11A'],
            ['nama_kelas' => '12A'],
        ];

        DB::table('tb_kelas')->insert($paralels);
    }
}
