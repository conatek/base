<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CollaboratorCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Validamos que is_foreigner sea booleano
            'is_foreigner' => 'nullable|boolean',

            'staff_provider_id' => 'required',
            'name' => 'required|string|max:255',
            'first_surname' => 'required|string|max:255',
            'second_surname' => 'nullable|string|max:255', // Agregado max:255 por seguridad
            'document_type_id' => 'required',
            'document_number' => 'required|string|max:50',
            'document_province_id' => 'required',
            'document_city_id' => 'required',
            'expedition_date' => 'required|date',

            // --- Lógica condicional de nacimiento ---
            'birth_province_id' => 'required_if:is_foreigner,0|nullable',
            'birth_city_id' => 'required_if:is_foreigner,0|nullable',
            'birth_date' => 'required|date',
            // ---------------------------------------

            'civil_status_type_id' => 'required',
            'sex_type_id' => 'required',
            'rh_type_id' => 'required',
            'observations' => 'nullable|string',
            'residence_province_id' => 'required',
            'residence_city_id' => 'required',
            'stratum_type_id' => 'required',
            'housing_tenure_id' => 'required',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'cellphone' => 'required|string|max:20',

            // --- CAMBIO EN EMAIL ---
            'email' => [
                'required',
                'email',
                'max:255',
                // 1. Debe ser único en la tabla collaborators
                Rule::unique('collaborators'), 
                
                // 2. Debe ser único en la tabla users
                // Esto previene que crees un colaborador suelto con el correo de un usuario existente
                Rule::unique('users'),
            ],

            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'Formato de imagen no admitido (usar jpeg, jpg, png).',
            'image.max' => 'El archivo excede el tamaño permitido (2048KB).',
            'staff_provider_id.required' => 'El proveedor es requerido.',
            'name.required' => 'El nombre es requerido.',
            'first_surname.required' => 'El primer apellido es requerido.',
            'document_type_id.required' => 'El tipo de documento es requerido.',
            'document_number.required' => 'El número de documento es requerido.',
            'document_province_id.required' => 'El departamento de expedición es requerido.',
            'document_city_id.required' => 'El municipio de expedición es requerido.',
            'expedition_date.required' => 'La fecha de expedición es requerida.',

            'birth_province_id.required_if' => 'El departamento de nacimiento es requerido para nacionales.',
            'birth_city_id.required_if' => 'El municipio de nacimiento es requerido para nacionales.',

            'birth_date.required' => 'La fecha de nacimiento es requerida.',
            'civil_status_type_id.required' => 'El estado civil es requerido.',
            'sex_type_id.required' => 'El sexo es requerido.',
            'rh_type_id.required' => 'El tipo de sangre es requerido.',
            'residence_province_id.required' => 'El departamento de residencia es requerido.',
            'residence_city_id.required' => 'El municipio de residencia es requerido.',
            'stratum_type_id.required' => 'El estrato social es requerido.',
            'housing_tenure_id.required' => 'El tipo de tenencia de vivienda es requerido.',
            'address.required' => 'La dirección es requerida.',
            'cellphone.required' => 'El número de celular es requerido.',
            
            // Mensajes para el Email
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado en el sistema.',
        ];
    }
}
