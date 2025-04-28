<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashOutflowTypes extends Model
{
    protected $fillable = [
        'cashoutflow_type_name',
        'cashoutflow_category_id',
        'cashoutflow_type_description',
    ];

    protected $casts = [
        'cashoutflow_type_name' => 'array',
    ];

    public function outflow_category()
    {
        return $this->belongsTo(CashOutflowCategories::class, 'cashoutflow_category_id', 'id');
    }

    public function outflows()
    {
        return $this->hasMany(CashOutflows::class, 'cashoutflow_type_id');
    }
}
