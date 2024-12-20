<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payroll extends Model
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
    protected $fillable  = [
        'employee_id',
        'payment_date',
        'pay_period',
        'gross_pay',
        'net_pay',
        'deductions',
        'compansation',
        'payment_method',
        'payment_status'
    ];

     public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
     public function client()
    {
        return $this->belongsTo(Client::class);
    }
}