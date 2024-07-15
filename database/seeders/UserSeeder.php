<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'testing',
            'phone_number' => '081234567890',
            // 'date_of_birth' => '2000-01-01',
            'address' => 'Jl. Jalan No. 1, Jakarta',
            'password' => bcrypt('password'),
        ]);
    }
}
