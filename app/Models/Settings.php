<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'system_name',
        'system_version',
        'system_favicon',
        'system_logo',
        'system_logo_report',
        'bg_login',
        'company_name',
        'company_cai',
        'company_rtn',
        'company_phone',
        'company_email',
        'company_address',
        'company_short_address',
    ];
}
