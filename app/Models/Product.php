<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'name',
        'description',
        'price',
        'category',
        'status'
    ];

        public function billings()
    {
        return $this->belongsToMany(Billing::class, 'orders')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
