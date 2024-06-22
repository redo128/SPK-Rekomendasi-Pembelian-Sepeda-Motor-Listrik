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
            'kriteria_id'=> 1,
            'min_rating' => '25',
            'max_rating'=>'36',
            'value'=>1
        ],[
            'id'=> 2,
            'kriteria_id'=> 1,
            'min_rating' => '37',
            'max_rating'=>'48',
            'value'=>2
        ],[
            'id'=> 3,
            'kriteria_id'=> 1,
            'min_rating' => '49 ',
            'max_rating'=>'55',
            'value'=>3
        ],['id'=> 4,
            'kriteria_id'=> 1,
            'min_rating' => '56',
            'max_rating'=>'63',
            'value'=>4
        ],['id'=> 5,
            'kriteria_id'=> 1,
            'min_rating' => '64',
            'max_rating'=>'70',
            'value'=>5
        ],['id'=> 6,
        'kriteria_id'=> 3,
        'min_rating' => '64',
        'max_rating'=>'70',
        'value'=>5
        ],[
            'id'=> 7,
        'kriteria_id'=> 2,
        'min_rating' => '25',
        'max_rating'=>'36',
        'value'=>1
        ],['id'=> 8,
        'kriteria_id'=> 2,
        'min_rating' => '37',
        'max_rating'=>'48',
        'value'=>2
        ],[
            'id'=> 9,
            'kriteria_id'=> 2,
            'min_rating' => '49',
            'max_rating'=>'55',
            'value'=>3
        ],[
            'id'=> 10,
            'kriteria_id'=> 2,
            'min_rating' => '56',
            'max_rating'=>'63',
            'value'=>4
        ] ,[
            'id'=> 11,
            'kriteria_id'=> 2,
            'min_rating' => '64',
            'max_rating'=>'70',
            'value'=>5
        ],[
            'id'=> 12,
            'kriteria_id'=> 3,
            'min_rating' => '3000000',
            'max_rating'=>'4699999',
            'value'=>5
        ],[
            'id'=> 13,
            'kriteria_id'=> 3,
            'min_rating' => '4700000',
            'max_rating'=>  '5899999',
            'value'=>4
        ],[
            'id'=> 14,
            'kriteria_id'=> 3,
            'min_rating' => '5900000',
            'max_rating'=>'7099999',
            'value'=>3
        ],[
            'id'=> 15,
            'kriteria_id'=> 3,
            'min_rating' => '7100000',
            'max_rating'=>  '8299999',
            'value'=>2
        
        ],[
            'id'=> 16,
            'kriteria_id'=> 3,
            'min_rating' => '8300000',
            'max_rating'=>  '10000000',
            'value'=>1
        
        ],
    ]);
    }
}
