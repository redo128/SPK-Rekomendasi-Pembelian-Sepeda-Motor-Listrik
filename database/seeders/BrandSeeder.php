<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brand')->insert([[
            'nama_brand' => 'UWINFLY',
            
        ],
        [
            'nama_brand' => 'GESITS',
        ],
        [
            'nama_brand' => 'VOLTA',
        ],
        [
            'nama_brand' => 'ECGO',
        ],
        [
            'nama_brand' => 'VIAR',
        ],
        [
            'nama_brand' => 'SELIS',
        ],
        ]);
    }
}
