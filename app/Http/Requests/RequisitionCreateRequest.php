<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequisitionCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'requisition_type_id' => 'required|exists:collaborator_requisition_types,id',
            'vacancies_count'     => 'required|integer|min:1',
            'campus_id'           => 'required|exists:campuses,id',
            'area_id'             => 'required|exists:areas,id',
            'position_id'         => 'required|exists:positions,id',
            'vacancy_reason_id'   => 'required|exists:vacancy_reasons,id',

            // Usamos required_if basándonos en los IDs exactos de la imagen:
            // 1: Reemplazo por retiro
            // 2: Reemplazo por licencia prolongada
            'replaces_id'         => [
                'nullable',
                'exists:collaborators,id',
                'required_if:vacancy_reason_id,1,2'
            ],

            'observations'        => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'requisition_type_id.required' => 'El tipo de requisición es obligatorio.',
            'requisition_type_id.exists' => 'El tipo de requisición seleccionado no es válido.',
            'vacancies_count.required' => 'El número de vacantes es obligatorio.',
            'vacancies_count.integer' => 'El número de vacantes debe ser un número entero.',
            'vacancies_count.min' => 'Debe solicitar al menos una vacante.',
            'campus_id.required' => 'La sede es obligatoria.',
            'campus_id.exists' => 'La sede seleccionada no es válida.',
            'area_id.required' => 'El área es obligatoria.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'position_id.required' => 'El cargo es obligatorio.',
            'position_id.exists' => 'El cargo seleccionado no es válido.',
            'vacancy_reason_id.required' => 'La razón de la vacante es obligatoria.',
            'vacancy_reason_id.exists' => 'La razón de vacante seleccionada no es válida.',
            'replaces_id.required_if' => 'Debe indicar a quién reemplaza cuando el motivo es por retiro o licencia prolongada.',
            'replaces_id.exists'  => 'El colaborador a reemplazar seleccionado no es válido.',
            'observations.string' => 'Las observaciones deben ser texto.',
            'observations.max' => 'Las observaciones no pueden exceder los 1000 caracteres.',
        ];
    }
}
