<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'product_barcode',
        'product_name',
        'product_description',
        'product_stock',
        'product_buy_price',
        'product_sell_price',
        'product_image',
    ];

    public function detalle_compre()
    {
        return $this->hasOne('App\Models\DetalleCompra');
    }

    public function detalle_venta()
    {
        return $this->hasOne('App\Models\DetalleVenta');
    }

    public function masDetalles()
    {
        return $this->hasMany('App\Models\DatosAdicionalesProductos');
    }

    public function clientTreatments()
    {
        return $this->belongsToMany(ClientTreatments::class, 'product_id');
    }
}
