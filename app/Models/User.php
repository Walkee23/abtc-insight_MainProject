<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    
    // Tell Laravel not to look for the default 'updated_at' column
    public $timestamps = false; 

    // Updated to match your v3.0 SQL columns exactly
    protected $fillable = [
        'username',
        'password_hash',
        'full_name',
        'role',
        'is_active',
        'barangay_assignment'
    ];

    protected $hidden = [
        'password_hash',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}