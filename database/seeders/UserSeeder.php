<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ustad',
                'email' => 'ustad@gmail.com',
                'password' => bcrypt('ustad123'),
                'role' => 'ustad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Santri',
                'email' => 'santri@gmail.com',
                'password' => bcrypt('santri123'),
                'role' => 'santri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Azril Delfrian Adi Putra',
                'email' => 'azril@hafalanqu.com',
                'password' => bcrypt('azril123'),
                'role' => 'santri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
