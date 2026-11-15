<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients'; 

    protected $fillable = [
        'first_name', 
        'last_name', 
        'phone_number', 
        'date_of_first_dose' // Your Day 0 column
    ];
}