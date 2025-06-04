<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_barcode' =>  'nullable|string|regex:/^[0-9]+$/|min:4|max:13|unique:productos',
            'product_name' => 'required|string|min:3|max:40',
            'product_description' => 'nullable|string|min:3|max:255',
            'product_stock' =>  'required|numeric|min:0',
            'product_buy_price' =>  'required|numeric|min:0.01',
            'product_sell_price' => 'required|numeric|max:999999999|gt:product_buy_price',
            'product_image' => 'image|mimes:jpeg,png,jpg,webp|max:8192' // Default (images/resources/no_image_available.png)
        ];
    }

    public function messages()
    {
        return [
            // Product barcode messages
            'product_barcode.string' => 'El código de barra del producto solo acepta números.',
            'product_barcode.min' => 'El código de barra del producto debe contener al menos 4 digitos.',
            'product_barcode.max' => 'El código de barra del producto no puede exceder 13 digitos.',
            'product_barcode.unique' => 'El código de barra del producto ya existe.',
            'product_barcode.regex' => 'El código de barra del producto debe contener únicamente números.',

            // Product product_name messages
            'product_name.required' => 'El nombre del producto es obligatorio.',
            'product_name.string' => 'El nombre del producto solo debe contener letras y números.',
            'product_name.min' => 'El nombre del producto debe contener al menos 3 letras.',
            'product_name.max' => 'El nombre del producto no puede exceder 40 letras.',

            // Product description messages
            'product_description.string' => 'La descripción del producto solo debe contener letras.',
            'product_description.min' => 'La descripción del producto debe contener al menos 3 letras.',
            'product_description.max' => 'La descripción del producto no puede exceder 255 letras.',

            // Product existance messages
            'product_stock.required' => 'La existencia del producto es obligatoria.',
            'product_stock.numeric' => 'La existencia del producto solo debe contener números.',
            'product_stock.min' => 'La existencia del producto debe ser mayor o igual a 0.',

            // Product purchase price
            'product_buy_price.numeric' => 'El precio de compra solo debe contener números.',
            'product_buy_price.required' => 'El precio de comprar es obligatorio.',
            'product_buy_price.min' => 'El precio de compra debe ser superior a L. 0.01.',
            'product_buy_price.max' => 'El precio de compra debe ser inferior al precio de venta.',

            // Product final price
            'product_sell_price.numeric' => 'El precio de venta solo acepta números.',
            'product_sell_price.required' => 'El precio de venta es obligatorio.',
            'product_sell_price.min' => 'El precio de venta debe ser superior al precio de venta al por mayor.',
            'product_sell_price.max' => 'El precio de venta debe ser inferior que L. 99,999,999.99.',
            'product_sell_price.gt' => 'El precio de venta debe ser mayor que el de compra.',

            // Product image
            'product_image.image' => 'La imagen del producto debe ser un archivo de tipo imagen (.png, .jpeg, .jpg, .webp).',
            'product_image.max' => 'La imagen que intenta subir es demasiado grande, intente optimizar la imagen.()',
        ];
    }
}
