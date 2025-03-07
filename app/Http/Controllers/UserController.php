<?php

namespace App\Http\Controllers;
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends  Authenticatable
{
    //
    use HasRoles;
}