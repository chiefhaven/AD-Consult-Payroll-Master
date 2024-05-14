<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResourceAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
            'prefix',
            'fname',
            'mname',
            'lname',
            'phone',
            'phone2',
            'current_address',
            'permanent_address',
            'nextofkin',
            'dateofbirth',
            'marital_status'     
    ];

}
