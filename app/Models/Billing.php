<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

        protected $fillable = [
            'client_name',
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
            'transaction_terms',
            'discription',
            'issue_date',
            'due_date',
            'client_id',
    ];
        public function Client()
    {
        return $this->belongsTo(Client::class);
    }
}