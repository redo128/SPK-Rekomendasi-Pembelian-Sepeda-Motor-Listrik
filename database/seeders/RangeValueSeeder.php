<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RangeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria_rating')->insert([[
            'id'=> 1,
            'kriteria_id'=> 4,
            'min_rating' => '3500000',
            'max_rating'=>'7000000',
            'value'=>1
        ],[
            'id'=> 2,
            'kriteria_id'=> 4,
            'min_rating' => '7000000',
            'max_rating'=>'10500000',
            'value'=>2
        ],[
            'id'=> 3,
            'kriteria_id'=> 4,
            'min_rating' => '10500000',
            'max_rating'=>'14000000',
            'value'=>3
        ],['id'=> 4,
            'kriteria_id'=> 4,
            'min_rating' => '14000000',
            'max_rating'=>'17500000',
            'value'=>4
        ],['id'=> 5,
        'kriteria_id'=> 4,
        'min_rating' => '17500000',
        'max_rating'=>'999999999',
        'value'=>5
        ],[
            'id'=> 6,
        'kriteria_id'=> 2,
        'min_rating' => '30',
        'max_rating'=>'40',
        'value'=>1
        ],['id'=> 7,
        'kriteria_id'=> 2,
        'min_rating' => '40',
        'max_rating'=>'50',
        'value'=>2
        ],[
            'id'=> 8,
            'kriteria_id'=> 2,
            'min_rating' => '50',
            'max_rating'=>'60',
            'value'=>3
        ]
        ]);
    }
}
