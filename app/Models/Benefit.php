<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;
        protected $fillable = [
            'employee_id',
            'type',
            'start_date',
            'end_date',
            'end_date',
            'coverage_level',
            'provider',
            'provider_phone_number',
            'provider_email',
            'employee_premium',
            'employer_contribution'
        ];
    
}
