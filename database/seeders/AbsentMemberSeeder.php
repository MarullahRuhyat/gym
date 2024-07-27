<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AbsentMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        for ($i = 0; $i < 10; $i++) {
            DB::table('absent_members')->insert([
                'member_id' => $faker->numberBetween(1, 10), // Sesuaikan dengan range member_id yang ada di tabel users
                'personal_trainer_id' => $faker->boolean(50) ? $faker->numberBetween(1, 10) : null, // 50% chance of having a personal_trainer_id or null
                'start_time' => $faker->time(),
                'end_time' => $faker->time(),
                'date' => $faker->date(),
                'qr_code' => Str::random(10),
                'path_qr_code' => $faker->filePath(),
                'jenis_latihan' => $faker->word(),
                'is_using_pt' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
