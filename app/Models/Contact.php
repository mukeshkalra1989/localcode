<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'phone_number', 'email', 'street_address', 'city', 'state', 'zip_code', 'date_of_birth',
    ];
}
