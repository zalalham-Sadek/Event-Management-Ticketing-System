<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\EventsTableSeeder;
use Database\Seeders\EventTypeSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

            $this->call(UsersTableSeeder::class);
            $this->call(EventTypeSeeder::class);
            $this->call(EventsTableSeeder::class);

    }
}
