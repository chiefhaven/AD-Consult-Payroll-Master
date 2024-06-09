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
            'employee_alt_number' => $this->faker->phoneNumber(5),
            'resident_state' => $this->faker->state(45),
            'resident_city' => $this->faker->state(45),
            'resident_country' => $this->faker->state(45),
            'resident_street' => $this->faker->state(45),
            'permanent_state' => $this->faker->state(45),
            'permanent_city' => $this->faker->state(45),
            'permanent_country' => $this->faker->state(45),
            'permanent_street' => $this->faker->state(45),
            'hiredate' => $this->faker->dateTime(),
            'education_level' => $this->faker->randomElement(['PhD', 'MSC', 'BSC', 'MSCE/GSCE', 'JCE', 'Other']),
            'workdept_id' => $this->faker->randomNumber(2),
            'designation_id' => $this->faker->randomNumber(1),
            'designated_location_specifics' => $this->faker->randomNumber(5),
            'id_type' => $this->faker->randomElement(['Malawi National ID', 'Passport', 'Driving Licence', 'Other']),
            'termination_notice_period' => $this->faker->randomNumber(3),
            'termination_notice_period_type' => $this->faker->randomElement(['Days', 'Weeks', 'Months']),
            'id_number' => $this->faker->sentence(5),
            'id_proof_pic' => $this->faker->sentence(8),
            'marital_status' => $this->faker->randomElement(['Married', 'Single', 'Widow', 'Divorced', 'Other']),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other', 'Them']),
            'birthdate' => $this->faker->dateTime(),
            'probation_period' => $this->faker->randomNumber(5),
            'salary' => $this->faker->randomNumber(6),
            'pay_period' => $this->faker->randomElement(['Daily', 'Weekly', 'Bi Weekly', 'Monthly']),
            'bonus' => $this->faker->randomNumber(6),
            'status' => $this->faker->randomElement(['Pending', 'Active', 'Contract terminated', 'Contract ended', 'Suspended', 'On Probation']),
            'client_id' => $this->faker->randomNumber(2),
            'paye' => $this->faker->boolean(),
            'project_id'=> $this->faker->randomNumber(2)
        ];
    }
}
