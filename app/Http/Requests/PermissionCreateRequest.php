<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionCreateRequest extends FormRequest
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
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'guard_name' => 'required',
            'module_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.unique' => 'El permiso ya está registrado.',
            'display_name.required' => 'El nombre a mostrar es requerido.',
            'guard_name.required' => 'El tipo de autenticación es requerido.',
            'module_id.required' => 'El módulo es requerido.',
        ];
    }
}
