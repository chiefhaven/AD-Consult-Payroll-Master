<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
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
        'billing_id',
        'product_id',
        'quantity',
        'rate',
        'total',
        'discount_amount',
        'discount_type',
        'tax_amount',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}