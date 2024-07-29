<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $numberOfRecords = 20; // Jumlah record yang ingin Anda buat

        $types = ['harian', 'mandiri', 'pt'];

        for ($i = 0; $i < $numberOfRecords; $i++) {
            DB::table('gym_membership_packages')->insert([
                'name' => $faker->words(3, true),
                'price' => $faker->numberBetween(50000, 1000000),
                'duration_in_days' => $faker->numberBetween(1, 365),
                'personal_trainer_quota' => $faker->numberBetween(0, 50),
                'description' => $faker->sentence,
                'type' => $faker->randomElement($types),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
