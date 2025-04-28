<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTreatments extends Model
{
    protected $fillable = [
        'client_treatment_date',
        'client_id',
        'client_treatment_description',
        'product_id',
        'client_treatment_notes'
    ];

    public function products()
    {
        return $this->belongsToMany(Producto::class, 'product_id');
    }
}
