<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:40|regex:/^[a-zA-Z]+\s[a-zA-Z]+(\s[a-zA-Z]+)?(\s[a-zA-Z]+)?$/',
            'email' => 'required|string|email|max:40|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required',
            'address' => 'string|min:3|max:250',
            'telephone' => 'string|min:8|max:8|regex:/([2,3,8,9]{1}[0-9]{7})/',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240'
        ];
    }

    public function messages()
    {
        return [
            // Client name messages
            'name.required' => 'El nombre del cliente es obligatorio.',
            'name.string' => 'El nombre del cliente solo debe contener letras.',
            'name.min' => 'El nombre del cliente debe contener al menos 3 letras.',
            'name.max' => 'El nombre del cliente no puede exceder 40 letras.',

            // Client email messages
            'email.required' => 'El email del cliente es obligatorio',
            'email.string' => 'El email del cliente solo debe contener letras.',
            'email.email' => 'El formato del email del cliente no es válido, ingrese correctamente el email.',
            'email.max' => 'El email no puede exceder 40 letras.',
            'email.unique' => 'El email del cliente ya existe.',

            // Client type messages
            'type.required' => 'El tipo de cliente en el sistema es obligatorio.',

            // Client customer messages
            'customer.required' => 'El tipo de comprador es obligatorio.',

            // Client password messages
            'password.required' => 'La contraseña del cliente es obligatoria',
            'password.confirmed' => 'La contraseña del cliente debe ser confirmada.',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres.',

            // Client address messages
            'address.required' => 'La dirección del cliente es obligatoria.',
            'address.string' => 'La dirección del cliente solo debe contener letras.',
            'address.min' => 'La dirección del cliente debe contener al menos 3 letas.',
            'address.max' => 'La dirección del cliente no puede exceder 150 letras.',

            'telephone.required' => 'El teléfono del empleado es obligatorio.',
            'telephone.unique' => 'El teléfono del empleado ya existe.',
            'telephone.regex' => 'El teléfono del empleado no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',
            'telephone.numeric' => 'El teléfono del empleado solo acepta números.',
        ];
    }
}
