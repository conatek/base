<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Datos Personales
            'name'           => 'required|string|max:255',
            'first_surname'  => 'required|string|max:255', // Nuevo campo obligatorio
            'second_surname' => 'nullable|string|max:255', // Nuevo campo opcional
            
            // Datos de Cuenta
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'company_id'     => 'required|exists:companies,id',
            'roles'          => 'required|array|min:1',
            
            // Imagen (Simplificado: si viene, debe cumplir reglas; si no, pasa)
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=200,max_height=200|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Los nombres son requeridos.',
            'first_surname.required'  => 'El primer apellido es requerido.',
            'email.required'          => 'El correo electrónico es requerido.',
            'email.email'             => 'El formato del correo no es válido.',
            'email.unique'            => 'Este correo ya está registrado en el sistema.',
            'company_id.required'     => 'Debe asociar una empresa.',
            'password.required'       => 'La contraseña es requerida.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
            'roles.required'          => 'Debe asignar al menos un rol.',
            
            // Mensajes de imagen
            'image.dimensions'        => 'La imagen no debe superar 200x200 píxeles.',
            'image.image'             => 'El archivo debe ser una imagen válida.',
            'image.mimes'             => 'Solo se permiten formatos jpeg, jpg y png.',
            'image.max'               => 'La imagen no debe pesar más de 100KB.',
        ];
    }
}
