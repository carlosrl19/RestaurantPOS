<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashOutflowCategories extends Model
{
    protected $fillable = [
        'cashoutflow_category_name',
        'cashoutflow_category_description',
    ];

    public function outflow_types()
    {
        return $this->hasMany(CashOutflowTypes::class, 'cashoutflow_category_id');
    }
}
