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

     protected $casts = [
        'country' => \WW\Countries\Casts\Country::class,
    ];

    protected $fillable = [
        'employee_no',
        'prefix',
        'fname',
        'mname',
        'sname',
        'phone',
        'employee_alt_number',
        'permanent_city',
        'permanent_state',
        'permanent_street',
        'hiredate',
        'education_level',
        'workdept_id',
        'designation_id',
        'designated_location',
        'designated_location_specifics',
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
        'nationality_id',
        'family_contact_name',
        'family_contact_number',
        'family_contact_alt_number',
        'company',
        'project',
        'contract_type',
        'contract_start_date',
        'contract_end_date',
        'probation_period',
        'termination_notice_period',
        'termination_notice_period_type',
        'basic_pay',
        'pay_period',
        'tax',
        'current_state',
        'current_city',
        'current_street',

    ];

    public function User()
    {
        return $this->hasOne(User::class);
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
