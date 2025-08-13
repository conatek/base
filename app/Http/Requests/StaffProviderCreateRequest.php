<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffProviderCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required',
            'provider_type_id' => 'required',
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'provider_type_id.required' => 'El tipo de proveedor es requerido.',
        ];
    }
}
