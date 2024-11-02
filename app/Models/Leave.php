<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
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