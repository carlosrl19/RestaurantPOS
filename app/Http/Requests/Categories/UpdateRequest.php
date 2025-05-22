<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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

    public function rules()
    {
        $categoryId = $this->route('category')->id;

        return [
            'category_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:categorias,category_name,' . $categoryId . '',
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
