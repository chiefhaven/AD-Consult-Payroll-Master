<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payroll extends Model
{
    use HasFactory;

    protected $fillable = [
       'employee_id',
       'payment_date',
       'pay_period',
       'gross_pay',
       'net_pay',
       'deductions',
       'compansation',
       'payment_method',
       'payment_status'
    ];
}
