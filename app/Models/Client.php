<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

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

    public function User()
    {
        return $this->hasOne(User::class);
    }

    public function Industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function Employee()
    {
        return $this->hasMany(Employee::class);
    }
    public function Billing()
    {
        return $this->hasMany(Billing::class);
    }
}