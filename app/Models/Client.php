<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'client_name',
        'contract_start_date',
        'contract_end_date',
        'client_logo',
        'phone',
        'phone2',
        'address',
        'street_address',
        'street_address_2',
        'zip_postal_code',
        'postal_code',
        'state',
        'city',
        'country_id',
        'industry_id',
        'tax_number_1',
        'tax_label_1',
        'tax_number_2',
        'tax_label_2',
        'time_zone',
        'status',
        'project',
        'website',
    ];

    // Relations

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function billing()
    {
        return $this->hasMany(Billing::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}
