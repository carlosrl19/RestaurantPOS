<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    public function compra()
    {
        return $this->hasMany('App\Models\Compra');
    }

    protected $fillable = [
        'provider_company_name',
        'provider_company_phone',
        'provider_company_rtn',
        'provider_company_address',
        'provider_contact_name',
        'provider_contact_phone',
    ];
}
