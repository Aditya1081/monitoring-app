<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JilidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $jilids = [
            ['nama_jilid' => 'Jilid 1'],
            ['nama_jilid' => 'Jilid 2'],
            ['nama_jilid' => 'Jilid 3'],
            ['nama_jilid' => 'Jilid 4'],
            ['nama_jilid' => 'Jilid 5'],
            ['nama_jilid' => 'Jilid 6'],
            ['nama_jilid' => 'Al Quran'],
        ];

        DB::table('tb_jilid')->insert($jilids);
    }
}
