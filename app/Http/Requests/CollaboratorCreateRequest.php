<?php

namespace App\Http\Requests;

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
            // Validamos que is_foreigner sea booleano (o 0/1)
            'is_foreigner' => 'nullable|boolean',

            'staff_provider_id' => 'required',
            'name' => 'required',
            'first_surname' => 'required',
            'document_type_id' => 'required',
            'document_number' => 'required',
            'document_province_id' => 'required',
            'document_city_id' => 'required',
            'expedition_date' => 'required',

            // --- CAMBIO CLAVE AQUÍ ---
            // Si is_foreigner es 0 (falso), estos campos son requeridos.
            // Si is_foreigner es 1 (verdadero), se vuelven nullable.
            'birth_province_id' => 'required_if:is_foreigner,0|nullable',
            'birth_city_id' => 'required_if:is_foreigner,0|nullable',
            'birth_date' => 'required',
            // -------------------------

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

            // --- AJUSTE DE MENSAJES ---
            // required_if lanzará el error si falta, pero podemos personalizar el mensaje
            // para que no suene confuso.
            'birth_province_id.required_if' => 'El departamento de nacimiento es requerido para nacionales.',
            'birth_city_id.required_if' => 'El municipio de nacimiento es requerido para nacionales.',
            // --------------------------

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
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingrese un correo electrónico válido.',
        ];
    }
}
