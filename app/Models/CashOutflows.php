<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashOutflows extends Model
{
    protected $fillable = [
        'cashoutflow_type_id',
        'cashoutflow_amount',
        'cashoutflow_image',
        'cashoutflow_description',
    ];

    public function outflow_type()
    {
        return $this->belongsTo(CashOutflowTypes::class, 'cashoutflow_type_id', 'id');
    }
}
