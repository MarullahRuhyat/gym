<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

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
            [
                'name' => 'Chavia',
                'password' => Hash::make('Haleluya1234567!'),
                'phone_number' => '081328903250',
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
                'name' => 'Frans Lee',
                'password' => Hash::make('Haleluya1234567!'),
                'phone_number' => '08170706999',
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
                'name' => 'Djing Susi',
                'password' => Hash::make('Haleluya1234567!'),
                'phone_number' => '087733773392',
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
                'name' => 'Caresse',
                'password' => Hash::make('Haleluya1234567!'),
                'phone_number' => '0882007114711',
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
                'name' => 'Fajar',
                'password' => Hash::make('Fajar12345678'),
                'phone_number' => '082138043151',
                'role' => 'personal trainer',
                'status' => 'active',
                'available_personal_trainer_quota' => 0,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Claus',
                'password' => Hash::make('Claus12345678'),
                'phone_number' => '082241698383',
                'role' => 'personal trainer',
                'status' => 'active',
                'available_personal_trainer_quota' => 0,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anna',
                'password' => Hash::make('Anna12345678'),
                'phone_number' => '082134839900',
                'role' => 'personal trainer',
                'status' => 'active',
                'available_personal_trainer_quota' => 0,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agus',
                'password' => Hash::make('Agus12345678'),
                'phone_number' => '089644064567',
                'role' => 'personal trainer',
                'status' => 'active',
                'available_personal_trainer_quota' => 0,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Melky',
                'password' => Hash::make('Melky12345678'),
                'phone_number' => '08970051838',
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
