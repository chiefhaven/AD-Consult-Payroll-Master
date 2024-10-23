<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(4),
            'price' => $this->faker->float(),
            'category' => $this->faker->randomElement(['Recruitment','Payroll','Training','Consulting']),
            'status' => $this->faker->randomElement(['Available','Not Available']),
        ];
    }
}