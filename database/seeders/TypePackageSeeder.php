<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $packages = [
            ['name' => 'Mandiri'],
            ['name' => 'Couple'],
            ['name' => 'Group'],
        ];

        DB::table('type_packages')->insert($packages);
    }
}
