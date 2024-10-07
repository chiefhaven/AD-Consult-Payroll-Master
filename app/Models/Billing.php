<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;
    
        protected $fillable = [
        'billing_no',
        'type',           
        'client_id',
        'amount',
        'issue_date',
        'due_date',
        'description',
        'status'
    ];
        public function Client()
    {
        return $this->belongsTo(Client::class);
    }
}