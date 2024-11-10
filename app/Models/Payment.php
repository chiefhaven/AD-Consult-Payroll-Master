<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    public function Billing()
    {
        return $this->belongsTo(Billing::class);
    }

}
