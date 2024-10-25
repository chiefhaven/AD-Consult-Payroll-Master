<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'billing_id' => \App\Models\Billing::factory(), // assuming a Billing factory exists
            'product_id' => \App\Models\Product::factory(), // assuming a related Product factory exists
            'quantity' => $this->faker->numberBetween(1, 100),
            'rate' => $this->faker->randomFloat(2, 1, 1000),
            'total' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['rate'];
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}