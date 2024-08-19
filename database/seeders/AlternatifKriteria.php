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
            'type'=>'benefit',
        ],[
            'id'=> 2,
            'nama_kriteria' => 'jarak tempuh',
            'type'=>'benefit'
        ],
        ['id'=> 3,
            'nama_kriteria' => 'lama pengisian baterai',
            'type'=>'cost'
        ],
        ['id'=> 4,
            'nama_kriteria' => 'biaya cas',
            'type'=>'cost'
        ],
        ['id'=> 5,
            'nama_kriteria' => 'keamanan',
            'type'=>'benefit'
        ],
        ['id'=> 6,
            'nama_kriteria' => 'desain',
            'type'=>'benefit'
        ],
        ['id'=> 7,
            'nama_kriteria' => 'harga',
            'type'=>'cost'
        ],
        ]);
    }
}
