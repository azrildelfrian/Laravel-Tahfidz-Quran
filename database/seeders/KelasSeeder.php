<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelas')->insert([
            [
                'id' => 1,
                'nama_kelas' => 'Kelas Contoh',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
