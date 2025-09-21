<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled', 'refunded']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'subtotal' => $this->faker->randomFloat(2, 50, 1000),
            'service_fee' => $this->faker->randomFloat(2, 5, 50),
            'tax_amount' => $this->faker->randomFloat(2, 10, 100),
            'total_amount' => $this->faker->randomFloat(2, 65, 1150),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
