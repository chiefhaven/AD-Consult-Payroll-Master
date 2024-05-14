<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'username',
        'password',
        'fname',
        'mname',
        'lname',
        'email',
        'phone_number',
        'role',
        'status',
        'profile_picture'

    ];
    
}
