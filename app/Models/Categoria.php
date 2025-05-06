<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    
    
    protected $fillable = ['nombre_Categoria'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function render()
    {
        $query = Producto::query();
    
        if ($this->categoriaSeleccionada) {
            $query->where('categoria_id', $this->categoriaSeleccionada);
        }
    
        return view('livewire.ventas.venta-create', [
            'productos' => $query->paginate(18),
            'categorias' => Categoria::all(), // <- aquí se envía la variable a la vista
        ])
        ->extends('layouts.layouts')
        ->section('content');
    }
}

