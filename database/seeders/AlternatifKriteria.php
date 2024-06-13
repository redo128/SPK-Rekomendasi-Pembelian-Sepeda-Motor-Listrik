<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlternatifKriteria extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria_alternatif')->insert([[
            'id'=> 1,
            'nama_kriteria' => 'kecepatan',
            'type'=>'benefit'
        ],[
            'id'=> 2,
            'nama_kriteria' => 'jarak tempuh',
            'type'=>'benefit'
        ],['id'=> 3,
            'nama_kriteria' => 'harga',
            'type'=>'cost'
        ]
        ]);
    }
}
