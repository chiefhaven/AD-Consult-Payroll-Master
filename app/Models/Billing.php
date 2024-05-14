<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
       'is_quotation',
       'is_invoice',
       'quotation_amount',
       'invoice_amount',
       'discount',
       'paid_amount',
       'status',
       'balance',
       'amount_before_tax',
       'tax_amount',
       'discount_type',
       'transaction_terms'
    ];
    
}
