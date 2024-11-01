<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
protected $fillable = [
    'Employee_no',
    'Name',
    'Surname',
    'Start Date',
    'Type',
    'Status',
    'Reason'
];

        public function employee()
    {
        return $this->belongsTo(Employee::class,);
    }


}