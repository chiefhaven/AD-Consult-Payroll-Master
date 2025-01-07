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
            'gross_pay' => $this->faker->randomFloat(2, 300000, 900000),
            'net_pay' => $this->faker->randomFloat(2, 200500, 800500),
            'other_deductions' =>$this->faker->randomFloat(2, 300, 900),
            'total_tax_amount' =>$this->faker->randomFloat(2, 1500, 3000),
            'commission' =>$this->faker->randomFloat(2, 300, 2000),
            'bonus' =>$this->faker->randomFloat(2, 300, 2000),
            'health_insurance'=>$this->faker->randomFloat(2, 100, 900),
            'payment_method' => $this->faker->randomElement(['Direct Deposit','Cheque']),
            'payment_status' => 'Draft',
        ];
    }
}