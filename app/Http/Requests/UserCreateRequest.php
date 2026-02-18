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
            'name'           => 'required|string|max:255',
            'first_surname'  => 'required|string|max:255',
            'second_surname' => 'nullable|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'company_id'     => 'required|exists:companies,id',
            'roles'          => 'required|array|min:1',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Los nombres son requeridos.',
            'name.string'             => 'Los nombres deben ser texto.',
            'name.max'                => 'Los nombres no pueden exceder los 255 caracteres.',
            'first_surname.required'  => 'El primer apellido es requerido.',
            'first_surname.string'    => 'El primer apellido debe ser texto.',
            'first_surname.max'       => 'El primer apellido no puede exceder los 255 caracteres.',
            'second_surname.string'   => 'El segundo apellido debe ser texto.',
            'second_surname.max'      => 'El segundo apellido no puede exceder los 255 caracteres.',
            'email.required'          => 'El correo electrónico es requerido.',
            'email.email'             => 'El formato del correo no es válido.',
            'email.unique'            => 'Este correo ya está registrado en el sistema.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
            'company_id.required'     => 'Debe asociar una empresa.',
            'company_id.exists'       => 'La empresa seleccionada no es válida.',
            'roles.required'          => 'Debe asignar al menos un rol.',
            'roles.array'             => 'Los roles deben ser un arreglo válido.',
            'roles.min'               => 'Debe asignar al menos un rol.',
            'image.image'             => 'El archivo debe ser una imagen válida.',
            'image.mimes'             => 'Solo se permiten formatos jpeg, jpg y png.',
            'image.max'               => 'La imagen no debe pesar más de 2048KB.',
        ];
    }
}
