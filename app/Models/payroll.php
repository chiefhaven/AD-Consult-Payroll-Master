<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payroll extends Model
{
    use HasFactory;
    protected $fillable  = [
        'name',
        'total',
        'date',
        'total_employees',
        'status'
    ];
}