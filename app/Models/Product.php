<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    public function getRouteKeyName()
    {
        return 'id'; // or whatever column holds the UUID
    }

    public function billings()
    {
        return $this->belongsToMany(Billing::class, 'bill_product')
                    ->withPivot('quantity', 'price', 'total')
                    ->withTimestamps();
    }
}
