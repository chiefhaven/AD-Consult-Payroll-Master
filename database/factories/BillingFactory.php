<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => $this->faker->randomNumber(),
            'client_name' => $this->faker->sentence(2),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'bill_type' => $this->faker->randomElement(['invoice', 'quotation']),
            'discount_type' => $this->faker->randomElement(['loyalty', 'trade', 'no discount']),
            'total_amount' => $this->faker->randomFloat(2, 1, 99999),
            'discount' => $this->faker->randomFloat(2, 1, 39999),
            'paid_amount' => $this->faker->randomFloat(2, 1, 99999),
            'balance' => $this->faker->randomFloat(2, 1, 89999),
            'tax_amount' => $this->faker->randomFloat(2, 1, 19999),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'discription' => $this->faker->sentence(7),
            'transaction_terms' => $this->faker->sentence(10),

        ];
    }
}