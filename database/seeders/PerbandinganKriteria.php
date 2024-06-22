<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerbandinganKriteria extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perbandingan_kriteria')->insert([
            [
            'kriteria_1' => 1,
            'kriteria_2'=> 1,
            'rating'=>'1'
        ],
            [
            'kriteria_1' => 1,
            'kriteria_2'=> 2,
            'rating'=>'3'
        ],
            [
            'kriteria_1' => 1,
            'kriteria_2'=> 3,
            'rating'=>'3'
        ],
            [
            'kriteria_1' => 2,
            'kriteria_2'=> 1,
            'rating'=>'0.33'
        ],
            [
            'kriteria_1' => 2,
            'kriteria_2'=> 2,
            'rating'=>'1'
        ],
            [
            'kriteria_1' => 2,
            'kriteria_2'=> 3,
            'rating'=>'3'
        ],
            [
            'kriteria_1' => 3,
            'kriteria_2'=> 1,
            'rating'=>'0.33'
        ],
            [
            'kriteria_1' => 3,
            'kriteria_2'=> 2,
            'rating'=>'0.33'
        ],
            [
            'kriteria_1' => 3,
            'kriteria_2'=> 3,
            'rating'=>'1'
        ],
            
        ]);
    }
}
