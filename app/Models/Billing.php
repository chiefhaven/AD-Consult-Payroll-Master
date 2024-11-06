<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'client_id',
        'billing_type',
        'amount',
        'discount',
        'discount_type',
        'paid_amount',
        'balance',
        'amount_before_tax',
        'tax_amount',
        'tax_rate',
        'tax_inclusive',
        'shipping_amount',
        'other_charges',
        'billing_date',
        'due_date',
        'payment_due_date',
        'overdue_date',
        'invoice_number',
        'reference_number',
        'currency',
        'payment_method',
        'payment_status',
        'reminder_sent',
        'is_recurring',
        'recurrence_period',
        'late_fee',
        'penalty_rate',
        'transaction_terms',
        'notes',
        'contact_email',
        'contact_phone',
        'billing_address',
        'shipping_address',
        'transaction_id',
        'payment_gateway',
        'attachment_path'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bill_product')
                    ->withPivot('quantity', 'price', 'item_discount', 'tax', 'taxType', 'total')
                    ->withTimestamps();
    }

}
