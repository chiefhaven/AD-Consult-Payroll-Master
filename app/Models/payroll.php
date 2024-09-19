<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [

    ];

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, "payroll_employee"); //komatu
    }
}
