<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [

    ];

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, "payroll_employee")->withPivot('salary', 'pay_period', 'earning_description', 'earning_amount', 'deduction_description', 'deduction_amount', 'payee', 'net_salary', 'total_paid'); //komatu
    }
}
