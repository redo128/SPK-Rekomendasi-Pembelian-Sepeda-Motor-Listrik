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
            'id' => 1,
            'nama_toko' => 'bukan_penjual',
            'alamat'=>'kosong'
        ],[
            'id' => 2,
            'nama_toko' => 'merkurius',
            'alamat'=>'planet 1' 
        ],
        [
            'id' => 3,
            'nama_toko' => 'venus',
            'alamat'=>'planet 2' 
        ],
        [
            'id' => 4,
            'nama_toko' => 'bumi',
            'alamat'=>'planet 3' 
        ],
        [
            'id' => 5,
            'nama_toko' => 'mars',
            'alamat'=>'planet 4' 
        ],
        ]);
    }
}
