<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_no' => $this->faker->randomNumber(3),
            'prefix' => $this->faker->title(),
            'fname' => $this->faker->firstName(),
            'mname' => $this->faker->lastName(),
            'sname' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(5),
            'phone2' => $this->faker->phoneNumber(5),
            'current_address' => $this->faker->address(45),
            'permanent_address' => $this->faker->address(45),
            'hiredate' => $this->faker->dateTime(),
            'education_level' => $this->faker->sentence(9),
            'workdept_id' => $this->faker->randomNumber(2),
            'designation_id' => $this->faker->randomNumber(1),
            'id_type' => $this->faker->randomNumber(2),
            'id_number' => $this->faker->name(5),
            'id_proof' => $this->faker->name(8),
            'marital_status' => $this->faker->sentence(5),
            'gender' => $this->faker->text(5),
            'birthdate' => $this->faker->dateTime(),
            'salary' => $this->faker->randomNumber(6),
            'bonus' => $this->faker->randomNumber(6),
            'status' => $this->faker->text(),
            'contact_id' => $this->faker->randomNumber(2),
            'client_id' => $this->faker->randomNumber(2),
            'com' => $this->faker->sentence(10),
        ];
    }
}
