<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jumlahJuz = 30;

        for ($juz = 1; $juz <= $jumlahJuz; $juz++) {
            DB::table('juz')->insert([
                'juz' => $juz,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
