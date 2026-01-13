<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollaboratorEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Obtenemos el objeto colaborador de la ruta
        // (Laravel Route Model Binding inyecta el modelo completo)
        $collaborator = $this->route('collaborator'); 

        return [
            // Validamos que is_foreigner sea booleano (o 0/1)
            'is_foreigner' => 'nullable|boolean',

            'staff_provider_id' => 'required',
            'name' => 'required|string|max:255',
            'first_surname' => 'required|string|max:255',
            'second_surname' => 'nullable|string|max:255',
            'document_type_id' => 'required',
            'document_number' => 'required',
            'document_province_id' => 'required',
            'document_city_id' => 'required',
            'expedition_date' => 'required|date',

            // Lógica condicional de nacimiento
            'birth_province_id' => 'required_if:is_foreigner,0|nullable',
            'birth_city_id' => 'required_if:is_foreigner,0|nullable',
            'birth_date' => 'required|date',

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

            // --- VALIDACIÓN DE EMAIL ACTUALIZADA ---
            'email' => [
                'required',
                'email',
                'max:255',
                // 1. Debe ser único en la tabla collaborators, PERO ignorando este registro actual
                Rule::unique('collaborators')->ignore($collaborator->id),
                
                // 2. (Recomendado) Verificar también en la tabla users para evitar errores de sincronización
                // Ignoramos el user_id asociado a este colaborador (si tiene uno)
                Rule::unique('users')->ignore($collaborator->user_id),
            ],

            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
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
            
            // Mensajes de Email
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado por otro usuario o colaborador.',
            
            // Mensajes de Imagen
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'Formato de imagen no admitido (usar jpeg, jpg, png).',
            'image.max' => 'El archivo excede el tamaño permitido (2048KB).',
        ];
    }
}