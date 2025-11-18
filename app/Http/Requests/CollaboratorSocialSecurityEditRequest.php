<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollaboratorSocialSecurityEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'collaborator_id' => 'required|integer',
            'eps_id'          => 'required|integer',
            'afp_pension_id'  => 'required|integer',
            'afp_saving_id'   => 'required|integer',
            'ccf_id'          => 'required|integer',
            'arl_id'          => 'required|integer',
            'observations'    => 'nullable|string',

            // Archivos opcionales
            'eps_file'         => 'nullable|max:2048|mimes:pdf',
            'afp_pension_file' => 'nullable|max:2048|mimes:pdf',
            'afp_saving_file'  => 'nullable|max:2048|mimes:pdf',
        ];
    }

    public function messages(): array
    {
        return [
            'collaborator_id.required' => 'El colaborador es requerido.',
            'collaborator_id.integer'  => 'El colaborador debe ser un número entero.',

            'eps_id.required' => 'La EPS es requerida.',
            'eps_id.integer'  => 'La EPS debe ser un número entero.',

            'afp_pension_id.required' => 'La AFP de pensión es requerida.',
            'afp_pension_id.integer'  => 'La AFP de pensión debe ser un número entero.',

            'afp_saving_id.required' => 'La AFP de cesantías es requerida.',
            'afp_saving_id.integer'  => 'La AFP de cesantías debe ser un número entero.',

            'ccf_id.required' => 'La Caja de Compensación es requerida.',
            'ccf_id.integer'  => 'La Caja de Compensación debe ser un número entero.',

            'arl_id.required' => 'La ARL es requerida.',
            'arl_id.integer'  => 'La ARL debe ser un número entero.',

            // Mensajes para el archivo EPS
            'eps_file.max'   => 'El certificado EPS no debe ser mayor a 2MB.',
            'eps_file.mimes' => 'El certificado EPS debe ser un PDF.',

            // Mensajes para el archivo de Pensión
            'afp_pension_file.max'   => 'El certificado de pensión no debe ser mayor a 2MB.',
            'afp_pension_file.mimes' => 'El certificado de pensión debe ser un PDF.',

            // Mensajes para el archivo de Cesantías
            'afp_saving_file.max'  => 'El certificado de cesantías no debe ser mayor a 2MB.',
            'afp_saving_file.mimes'  => 'El certificado de cesantías debe ser un PDF.',
        ];
    }
}
