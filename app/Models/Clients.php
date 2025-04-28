<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'client_name',
        'client_phone',
        'client_email',
        'client_address',
    ];    
}
