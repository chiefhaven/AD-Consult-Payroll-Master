<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $casts = ['id'=>'string'];
    protected $keyType = 'string';

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
        'id',
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

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
    public function billing()
    {
        return $this->hasMany(Billing::class);
    }
    public function payroll()
    {
        return $this->hasMany(Payroll::class);
    }
}