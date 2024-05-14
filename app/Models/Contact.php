<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'client_id',
        'fname',
        'lname',
        'email_address',
        'phone_number',
        'country',
        'city',
        'state',
        'street',
        'postal_code'
    ];
}
