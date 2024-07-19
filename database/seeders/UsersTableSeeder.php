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
        ]);
        foreach (range(1, 7) as $index) {
            $role = $faker->randomElement(['member', 'personal trainer']);
            $available_personal_trainer_quota = $role == 'personal trainer' ? 0 : $faker->numberBetween(0, 20);

            DB::table('users')->insert([
                'name' => $faker->name,
                'password' => bcrypt('password'), // Example password
                'phone_number' => $faker->phoneNumber,
                'role' => $role,
                'status' => $faker->randomElement(['active', 'inactive', 'expired']),
                'available_personal_trainer_quota' => $available_personal_trainer_quota,
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'otp' => null,
                'otp_expired_at' => null,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'salary_pt' => null,
            ]);
        }
    }
}
