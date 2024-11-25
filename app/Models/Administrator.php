<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Administrator extends Model
{
    use Notifiable, HasUuids, HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    public function User()
    {
        return $this->hasOne(User::class);
    }

}
