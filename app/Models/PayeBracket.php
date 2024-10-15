<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayeBracket extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    // Specify the table name if it does not follow Laravel's naming convention
    protected $table = 'paye_brackets';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'limit',
        'rate',
    ];
}
