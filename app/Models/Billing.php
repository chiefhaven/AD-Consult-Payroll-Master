<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

        protected $fillable = [
            'client_id',
            'bill_type',
            'quotation_amount',
            'invoice_amount',
            'discount',
            'paid_amount',
            'status',
            'balance',
            'tax_amount',
            'discount_type',
            'transaction_terms',
            'discription',
            'issue_date',
            'due_date',

    ];
        public function Client()
    {
        return $this->hasMany(Client::class);
    }
}