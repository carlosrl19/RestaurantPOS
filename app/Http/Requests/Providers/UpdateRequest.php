<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $proveedorId = $this->route('proveedor')->id;

        return [
            'provider_company_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:proveedors,provider_company_name,' . $proveedorId . '',
            'provider_company_rtn' => 'required|regex:/^[0-9]+$/|string|min:14|max:14',
            'provider_company_phone' => 'required|string|min:8|max:8|regex:([2,3,8,9]{1}[0-9]{7})',
            'provider_company_address' => 'required|string|min:3|max:255',
            'provider_contact_name' => 'required|string|min:3|max:55|regex:/^[^\d]+$/',
            'provider_contact_phone' => 'required|string|min:8|max:8|regex:([2,3,8,9]{1}[0-9]{7})'
        ];
    }

    public function messages()
    {
        return [
            // Product provider company messages
            'provider_company_name.required' => 'La empresa proveedora es obligatoria.',
            'provider_company_name.string' => 'La empresa proveedora no acepta números ni símbolos.',
            'provider_company_name.min' => 'La empresa proveedora debe contener al menos 3 letras.',
            'provider_company_name.max' => 'La empresa proveedora no puede exceder 55 letras.',
            'provider_company_name.regex' => 'La empresa proveedora debe contener únicamente letras.',
            'provider_company_name.unique' => 'La empresa proveedora ya existe.',

            // Product marca messages
            'provider_company_rtn.required' => 'El RTN de la empresa proveedora es obligatorio.',
            'provider_company_rtn.regex' => 'El RTN de la proveedora debe contener únicamente números.',
            'provider_company_rtn.string' => 'El RTN de la empresa proveedora no acepta letras ni símbolos.',
            'provider_company_rtn.min' => 'El RTN de la empresa proveedora debe contener al menos 14 dígitos.',
            'provider_company_rtn.max' => 'El RTN de la empresa proveedora no puede exceder 14 dígitos.',

            // Product model messages
            'provider_company_phone.required' => 'El teléfono del proveedor es obligatorio.',
            'provider_company_phone.string' => 'El teléfono del proveedor solo acepta números.',
            'provider_company_phone.min' => 'El teléfono del proveedor debe contener al menos 8 dígitos.',
            'provider_company_phone.max' => 'El teléfono del proveedor no puede exceder 8 dígitos.',
            'provider_company_phone.unique' => 'El teléfono del proveedor ya existe.',
            'provider_company_phone.regex' => 'El teléfono del proveedor no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',

            // Product description messages
            'provider_company_address.required' => 'La dirección del proveedor es obligatoria.',
            'provider_company_address.string' => 'La dirección del proveedor solo debe contener letras.',
            'provider_company_address.min' => 'La dirección del proveedor debe contener al menos 3 letras.',
            'provider_company_address.max' => 'La dirección del proveedor no puede exceder 255 letras.',

            // Product existance messages
            'provider_contact_name.required' => 'El nombre del vendedor del proveedor es obligatoria.',
            'provider_contact_name.string' => 'El nombre del vendedor del proveedor no acepta números ni símbolos.',
            'provider_contact_name.min' => 'El nombre del vendedor del proveedor debe contener al menos 3 letras.',
            'provider_contact_name.max' => 'El nombre del vendedor del proveedorno puede exceder 55 letras.',
            'provider_contact_name.regex' => 'El nombre del vendedor del proveedor debe contener únicamente letras.',

            // Product model messages
            'provider_contact_phone.required' => 'El teléfono del vendedor del proveedor es obligatorio.',
            'provider_contact_phone.string' => 'El teléfono del vendedor del proveedor solo acepta números.',
            'provider_contact_phone.min' => 'El teléfono del vendedor del proveedor debe contener al menos 8 dígitos.',
            'provider_contact_phone.max' => 'El teléfono del vendedor del proveedor no puede exceder 8 dígitos.',
            'provider_contact_phone.regex' => 'El teléfono del vendedor del proveedor no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',
        ];
    }
}
