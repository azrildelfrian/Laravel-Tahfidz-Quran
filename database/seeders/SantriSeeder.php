<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SantriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('santri')->insert([
            [
                'id' => 1,
                'id_santri' => 3,
                'halaqoh_id' => 1,
                'kelas_id' => 1,
                'nomor_id' => 'SN001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'id_santri' => 4,
                'halaqoh_id' => 1,
                'kelas_id' => 1,
                'nomor_id' => 'SN002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
