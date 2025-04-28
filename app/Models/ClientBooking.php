<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientBooking extends Model
{
    protected $fillable = [
        'client_booking_date',
        'client_name',
        'client_booking_description',
        'client_booking_status',
        'client_booking_cancellation',
    ];
}
