<?php

namespace App\Http\Livewire\Ventas;

use App\Models\DetalleVenta;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class VentaIndex extends Component
{
    public function render()
    {
        return view('livewire.ventas.venta-index', [
            'ventas' => Venta::orderBy('created_at','desc')
                ->paginate(50)
        ])
            ->extends('layouts.layouts')
            ->section('content');
    }

    public function eliminarVenta($id)
    {
        $venta = Venta::findOrFail($id);

        if ($venta) {
            DetalleVenta::where('venta_id', $venta->id)->delete();
            $venta->delete();
        }

        return redirect()->route('ventas.index')->with('success', '¡Venta eliminada con éxito!');
    }
}
