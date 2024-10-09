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
            'client_name' => $this->faker->sentence(2),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'amount' => $this->faker->randomFloat(2, 1, 99999),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'description' => $this->faker->sentence(7),
            'is_invoice' => $this->faker->boolean(),
            'is_quotation' => $this->faker->boolean(),




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