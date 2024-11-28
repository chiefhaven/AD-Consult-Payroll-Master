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

    // Mass assignable attributes
    protected $fillable = [
        'first_name',
        'middle_name',
        'sirname',
        'phone',
        'alt_phone',
        'street_address',
        'district',
        'country',
        'profile_picture',
        'role',
        'is_active',
    ];

    public function User()
    {
        return $this->hasOne(User::class);
    }

}
