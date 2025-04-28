<?php

namespace App\Http\Requests\Compras;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'compra_id' => 'required|exists:compras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad_detalle_compra' => 'required|integer|min:1',
            'product_buy_price' => 'required|numeric|min:0',
            'id_prove' => 'required|exists:proveedors,id',
        ];
    }

    public function messages()
    {
        return [
            // Compra id messages
            'compra_id.required' => 'El identificador de la compra es obligatorio.',

            // Product id messages
            'producto_id.required' => 'El producto a comprar es obligatorio.',

            // Quantity messages
            'cantidad_detalle_compra.required' => 'La cantidad a comprar es obligatorio.',

            // Buy price messages
            'product_buy_price.required' => 'El precio del producto es obligatorio.',

            // Provider id messages
            'id_prove.required' => 'El proveedor es obligatorio',
            'id_prove.exists' => 'El proveedor seleccionado no es válido.',
        ];
    }
}
