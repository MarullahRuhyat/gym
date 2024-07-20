<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('packages')->insert([
            'name' => 'Basic',
            'description' => 'Basic Package',
            'price' => 325000,
            'duration' => 30,
            'tipe' => 'harian',
        ]);

        DB::table('packages')->insert([
            'name' => 'Premium',
            'description' => 'Premium Package',
            'price' => 550000,
            'duration' => 60,
            'tipe' => 'mandiri',
        ]);

        DB::table('packages')->insert([
            'name' => 'Platinum',
            'description' => 'Platinum Package',
            'price' => 750000,
            'duration' => 90,
            'tipe' => 'pt',
        ]);

        DB::table('packages')->insert([
            'name' => 'Elite',
            'description' => 'Elite Package',
            'price' => 1250000,
            'duration' => 120,
            'tipe' => 'pt',
        ]);

        DB::table('packages')->insert([
            'name' => 'Ultimate',
            'description' => 'Ultimate Package',
            'price' => 2000000,
            'duration' => 360,
            'tipe' => 'pt',
        ]);
    }
}
