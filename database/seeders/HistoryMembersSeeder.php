<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HistoryMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        $numberOfRecords = 50;

        for ($i = 0; $i < $numberOfRecords; $i++) {
            $startDate = $faker->dateTimeBetween('-1 year', 'now');
            $endDate = (clone $startDate)->modify('+'.rand(1, 30).' days');

            DB::table('history_members')->insert([
                'member_id' => rand(1, 10), 
                'user_id' => rand(1, 10),  
                'is_active' => $faker->randomFloat(2, 0, 1),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'number_of_days_available_for_use' => rand(1, 30),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
