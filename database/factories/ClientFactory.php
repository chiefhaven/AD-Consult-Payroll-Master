<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->sentence(3),
            'contract_start_date' => $this->faker->date(),
            'client_logo' => $this->faker->imageUrl(),
            'phone' => $this->faker->phoneNumber(5),
            'phone2' => $this->faker->phoneNumber(5),
            'address' => $this->faker->address(45),
            'zip_postal_code' => $this->faker->postcode(5),
            'state' => $this->faker->word(5),
            'city' => $this->faker->city(),
            'country_id' => $this->faker->country(),
            'industry_id' => $this->faker->randomNumber(1),
            'tax_number_1' => $this->faker->randomNumber(2),
            'tax_label_1' => $this->faker->word(5),
            'tax_number_2' => $this->faker->randomNumber(5),
            'tax_label_2' => $this->faker->word(5),
            'time_zone' => $this->faker->timezone(),
        ];
    }
}
