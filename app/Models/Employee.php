<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_no',
        'prefix',
        'fname',
        'mname',
        'sname',
        'phone',
        'phone2',
        'current_address',
        'permanent_address',
        'hiredate',
        'education_level',
        'workdept_id',
        'designation_id',
        'id_type',
        'id_number',
        'id_proof',
        'marital_status',
        'gender',
        'birthdate',
        'salary',
        'bonus',
        'status',
        'contact_id',
        'client_id',
        'com',
    ];

    public function User()
    {
        return $this->hasOne(User::class);
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }
}
