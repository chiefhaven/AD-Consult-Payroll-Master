<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    // The attributes that are mass assignable
    protected $fillable = [
        'prefix',
        'startNumber',
        'taxRate',
        'terms',
        'header',
        'footer',
        'seperator',
        'invoiceNumberIncludeClientName',
        'invoiceNumberIncludeYear',
    ];
}
