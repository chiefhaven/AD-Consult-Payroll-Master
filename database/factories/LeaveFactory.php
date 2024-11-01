<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Employee_no' => $this->faker->sentence(2),
            'Name' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'Surname' => $this->faker->randomElement(['invoice', 'quotation']),
            'Start_date' => $this->faker->date(),
            'Type' => $this->faker->randomElement(['Sick Leave','Marternity Leave','Annual Leave', 'Parental Leave','Unpaid Leave','Study Leave']),
            'Status' => $this->faker()->boolean(75),
            'Reason' => $this->faker->sentence(2),
        ];
    }
}
