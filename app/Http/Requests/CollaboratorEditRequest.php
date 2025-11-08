<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollaboratorEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'staff_provider_id' => 'required',
            'name' => 'required',
            'first_surname' => 'required',
            'document_type_id' => 'required',
            'document_number' => 'required',
            'document_province_id' => 'required',
            'document_city_id' => 'required',
            'expedition_date' => 'required',
            'birth_province_id' => 'required',
            'birth_city_id' => 'required',
            'birth_date' => 'required',
            'civil_status_type_id' => 'required',
            'sex_type_id' => 'required',
            'rh_type_id' => 'required',
            'observations' => 'nullable|string',
            'residence_province_id' => 'required',
            'residence_city_id' => 'required',
            'stratum_type_id' => 'required',
            'housing_tenure_id' => 'required',
            'address' => 'required',
            'phone' => 'nullable|string',
            'cellphone' => 'required',
            'email' => 'required|email',
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
            'birth_province_id' => 'El departamento de nacimiento es requerido.',
            'birth_city_id' => 'El municipio de nacimiento es requerido.',
            'birth_date' => 'La fecha de nacimiento es requerida.',
            'civil_status_type_id' => 'El estado civil es requerido.',
            'sex_type_id' => 'El sexo es requerido.',
            'rh_type_id' => 'El tipo de sangre es requerido.',
            'observations' => '',
            'residence_province_id' => 'El departamento de residencia es requerido.',
            'residence_city_id' => 'El municipio de residencia es requerido.',
            'stratum_type_id' => 'El estrato social es requerido.',
            'housing_tenure_id' => 'El tipo de tenencia de vivienda es requerido.',
            'address' => 'La dirección es requerida.',
            'phone' => '',
            'cellphone' => 'El número de celular es requerido.',
            'email' => 'El correo electrónico es requerido.',
        ];
    }
}
