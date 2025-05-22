<?php

namespace App\Http\Requests\Categories;

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
            'category_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:categorias',
        ];
    }

    public function messages()
    {
        return [
            'category_name.required' => 'El nombre de la categoría es obligatorio.',
            'category_name.string' => 'El nombre de la categoría no acepta números ni símbolos.',
            'category_name.min' => 'El nombre de la categoría debe contener al menos 3 letras.',
            'category_name.max' => 'El nombre de la categoría no puede exceder 55 letras.',
            'category_name.regex' => 'El nombre de la categoría debe contener únicamente letras.',
            'category_name.unique' => 'La categoría ya existe.',
        ];
    }
}
