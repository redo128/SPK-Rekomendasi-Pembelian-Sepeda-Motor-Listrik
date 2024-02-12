<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('toko')->insert([[
            'nama_toko' => 'kecepatan',
            'alamat'=>'benefit'
        ],[
            'nama_toko' => 'kecepatan2',
            'alamat'=>'benefit2',
        ]
        ]);
    }
}
