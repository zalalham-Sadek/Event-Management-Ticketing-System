<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 10, 100);
        
        return [
            'order_id' => Order::factory(),
            'ticket_id' => Ticket::factory(),
            'ticket_type' => $this->faker->randomElement(['General', 'VIP', 'Premium', 'Student']),
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'total_price' => $unitPrice * $quantity,
        ];
    }
}
