<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\User;
use App\Models\EventType;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<Event> */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        // Pick random user with role Organizer or Admin
        $user = User::whereIn('role', ['Organizer', 'Admin'])
            ->inRandomOrder()
            ->first();

        // If no user found, create one randomly (Organizer or Admin)
        if (!$user) {
            $role = $this->faker->randomElement(['Organizer', 'Admin']);
            $user = User::factory()->create(['role' => $role]);
        }

        // Pick a random event type (from seeder)
        $eventType = EventType::inRandomOrder()->first();

        if (!$eventType) {
            // If no event types exist yet, create one
            $eventType = EventType::factory()->create();
        }

        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'date'        => $this->faker->dateTimeBetween('now', '+2 months'),
            'location'    => $this->faker->city,
            'poster'      => null,
            'user_id'     => $user->id,
            'type' => $eventType->name,
        ];
    }
}
