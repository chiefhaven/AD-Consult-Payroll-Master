<?php

namespace Database\Factories;
use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
     protected $model = Leave::class;

         public function definition()
    {
        // Fetch a random employee's number (assuming 'employee_no' is the field in the Employee model)
        $employeeNos = Employee::pluck('employee_no')->toArray();

        return [
            'employee_no' => $this->faker->randomElement($employeeNos),
            'Name'=> $this->faker->firstName (1),
            'Surname'=> $this->faker->lastName (1),
            'Type' => $this->faker->randomElement(['Sick Leave','Marternity Leave','Annual Leave', 'Parental Leave','Unpaid Leave','Study Leave']),
            'start_date' => $this->faker->date(),
            'Status' => $this->faker->boolean(75),
            'Reason' => $this->faker->sentence(3),
        ];
    }
}