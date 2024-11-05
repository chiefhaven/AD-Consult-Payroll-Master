<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Billing extends Model
{
    use HasFactory;
    use HasUuids;

        public $incrementing = false;
        protected $casts = ['id'=>'string'];
        protected $keyType = 'string';

        protected static function boot()
    {
        parent::boot();

        // Automatically generate a UUID when creating a model
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }


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