<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Leave extends Model
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
    'employee_no',
    'Name',
    'Surname',
    'start_date',
    'Type',
    'Status',
    'Reason'
];

        public function employee()
    {
        return $this->belongsTo(Employee::class,);
    }


}
