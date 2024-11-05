<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
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

    protected $fillable=[
        'id',
        'name',
        'description',
        'price',
        'category',
        'status',
        'tax',
        'total'

    ];

        public function billings()
    {
        return $this->belongsToMany(Billing::class, 'orders')
                    ->withPivot('quantity', 'rate','total')
                    ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}