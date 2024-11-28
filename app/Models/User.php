<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasUuids, HasFactory, HasRoles;
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'client_id',
        'employee_id',
        'administrator_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'approval_by'); // Assuming approval_by is the foreign key in the leaves table
    }

    public function adminlte_image()
    {
        $profilePicturePath = Auth::user()->administrator->profile_picture;

        // Check if the profile picture exists and if it's stored in the public disk
        if ($profilePicturePath && Storage::disk('public')->exists($profilePicturePath)) {
            return asset('storage/' . $profilePicturePath);
        }

        // Return a default image if no profile picture exists
        return asset('storage/default-profile.png'); // Replace with the default image path if needed
    }

    public function adminlte_desc()
    {
        return 'I\'m a nice guy';
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
