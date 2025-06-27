<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HalaqohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('halaqoh')->insert([
            [
                'id' => 1,
                'ustad_pengampu' => 2,
                'nama_halaqoh' => 'Halaqoh Contoh',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
