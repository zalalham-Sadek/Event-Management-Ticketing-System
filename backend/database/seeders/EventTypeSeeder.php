<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventType;

class EventTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Conference'],
            ['name' => 'Workshop'],
            ['name' => 'Webinar'],
            ['name' => 'Meetup'],
            ['name' => 'Seminar'],
        ];

        foreach ($types as $type) {
            EventType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
