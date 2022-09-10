<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = "admin";		
    protected $fillable = [

        'username','name', 'email', 'password','company_name', 'is_admin'

    ];
    protected $hidden = [
        'password',
    ];
    public $timestamps = false;
}
