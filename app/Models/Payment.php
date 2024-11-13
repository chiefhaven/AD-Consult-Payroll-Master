<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'billing_id',
        'payment_amount',
        'payment_method',
        'payment_reference',
        'account_number',
        'cheque_number',
        'payment_status',
        'payment_date',
        'payment_gateway',
        'transaction_id',
        'notes',
        'created_by',
        'updated_by',
    ];


    public function Billing()
    {
        return $this->belongsTo(Billing::class);
    }

}
