<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Billing extends Model
{
    use HasFactory;
    // use HasUuids;

        protected $fillable = [
            'client_id',
            'bill_type',
            'total_amount',
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
            
            // 'product',
            // 'quantity',
            // 'rate',

    ];
        public function client()
    {
        return $this->belongsTo(Client::class,);
    }

    //  public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'orders')
    //                 ->withPivot('quantity', 'rate', 'total');
    //                 // ->withTimestamps();
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }



}
