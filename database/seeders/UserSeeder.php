<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([[
            'name' => Str::random(10),
            'email' => Str::random(10).'@example.com',
            'role' => 'superadmin',
            'toko_id' => 1,
            'password' => Hash::make('password'),
        ],[
            'name' => "SA",
            'email' => 'sa@example.com',
            'role' => 'superadmin',
            'toko_id' => 1,
            'password' => Hash::make('password'),
        ],[
            'name' => "penjualadit",
            'email' => 'penjual@example.com',
            'role' => 'penjual',
            'toko_id' => 2,
            'password' => Hash::make('password'),
        ],[
            'name' => "pembeliadit",
            'email' => 'pembeli@example.com',
            'role' => 'pembeli',
            'toko_id' => 1,
            'password' => Hash::make('password'),
        ],
    ]);
    }
}
