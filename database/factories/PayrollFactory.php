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
        $employeeIds  = Employee::pluck('id')->toArray();
        return [
            'employee_id' => $this->faker->randomElement($employeeIds),
            'payment_date'=> $this->faker->dateTimeThisYear(),
            'pay_period'=> $this->faker->randomElement(['Weekly','Bi weekly','Monthly']),
            'gross_pay' => $this->faker->randomFloat(2, 30000, 150000),
            'net_pay' => $this->faker->randomFloat(2, 30000, 150000),
            'deductions' => $this->faker->randomFloat(2, 3000, 1500),
            'compansation' => $this->faker->randomElement(['Commission','Bonus']),
            'payment_method' => $this->faker->randomElement(['Direct Deposit','Cheque']),
            'payment_status' => 'Draft',
        ];
    }
}