<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{
    public function run(): void
    {
        Event::factory()->count(20)->create();
    }
}
