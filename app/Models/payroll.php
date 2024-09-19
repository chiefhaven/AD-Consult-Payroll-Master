<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable = [

    ];

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Employee()
    {
        return $this->belongsToMany(Employee::class, "payroll_employee");
    }
}
