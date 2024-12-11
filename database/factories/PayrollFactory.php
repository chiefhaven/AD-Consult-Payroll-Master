<?php

namespace Database\Factories;
use App\Models\Employee;
use App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\payroll>
 */
class PayrollFactory extends Factory
{
    protected $model = Payroll::class;
    
    public function definition()
    {
        $employeeNos = Employee::pluck('employee_no')->toArray();
        return [
            'employee_id' => $this->faker->randomElement($employeeNos),
            'payment_date'=> $this->faker->dateTimeThisYear(),
            'pay_period'=> $this->faker->dateTimeThisYear(),
            'gross_pay' => $this->faker->randomFloat(2, 30000, 150000),
            'net_pay' => $this->faker->randomFloat(2, 30000, 150000),
            'deductions' => $this->faker->randomFloat(2, 3000, 1500),
            'compansation' => $this->faker->randomFloat(2, 3000, 1500),
            'payment_method' => $this->faker->randomElement(['Cheque','Bank Transfer','Cash']),
            'payment_status' =>$this->faker->randomElement(['Draft','Paid']),
        ];
    }
}