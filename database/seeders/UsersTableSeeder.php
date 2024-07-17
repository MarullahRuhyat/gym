<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Ruhyat',
                'password' => Hash::make('password'),
                'phone_number' => '08994668927',
                'role' => 'admin',
                'status' => 'active',
                'available_personal_trainer_quota' => 0,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Henny',
                'password' => Hash::make('password'),
                'phone_number' => '085879307437',
                'role' => 'member',
                'status' => 'active',
                'available_personal_trainer_quota' => 11,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kamil',
                'password' => Hash::make('password'),
                'phone_number' => '085172014124',
                'role' => 'personal trainer',
                'status' => 'active',
                'available_personal_trainer_quota' => 0,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
