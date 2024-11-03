<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasUuids;
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approval_by', 'id'); // 'id' is the local key in the users table, assuming 'approval_by' is the foreign key in leaves
    }

}
