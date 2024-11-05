<?php

namespace Database\Factories;
use Illuminate\Support\Str;

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
            'id' => (string) Str::uuid(),
            'client_name' => $this->faker->name(2),
            'contract_start_date' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber(5),
            'phone2' => $this->faker->phoneNumber(5),
            'address' => $this->faker->address(45),
            'zip_postal_code' => $this->faker->postcode(5),
            'state' => $this->faker->word(5),
            'city' => $this->faker->city(),
            'country_id' => $this->faker->randomNumber(1),
            'industry_id' => $this->faker->randomNumber(1),
            'website' => $this->faker->domainName(),
            'tax_number_1' => $this->faker->randomNumber(2),
            'tax_label_1' => $this->faker->word(5),
            'tax_number_2' => $this->faker->randomNumber(5),
            'tax_label_2' => $this->faker->word(5),
            'time_zone' => $this->faker->timezone(),
            'status' => $this->faker->randomElement(['Pending', 'Active', 'Contract terminated', 'Contract ended', 'Suspended']),


        ];
    }
}
