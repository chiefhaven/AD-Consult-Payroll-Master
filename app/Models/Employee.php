<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $keyType = 'string';
    public $incrementing = false;
    protected $casts = [
        'country' => \WW\Countries\Casts\Country::class,
        'id'=>'string'
    ];
    protected static function boot()
    {
        parent::boot();

        // Automatically generate a UUID when creating a model
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }


    protected $fillable = [
        'employee_no',
        'prefix',
        'fname',
        'mname',
        'sname',
        'phone',
        'employee_alt_number',
        'resident_state',
        'resident_city',
        'resident_street',
        'resident_country',
        'permanent_city',
        'permanent_state',
        'permanent_street',
        'permanent_country',
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
        'paye',

    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
}