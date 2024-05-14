<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
               'clock_in_time',
               'clock_out_time',
                'ip_address',
                'clock_in_note',
                'clock_out_note',
                'clock_in_location',
                'clock_out_location'
    ];
}
