<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HistoryMember;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\HistoryMembersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            PackageSeeder::class,
            UsersTableSeeder::class,
            HistoryMembersSeeder::class,
            AbsentMemberSeeder::class,
        ]);
    }
}
