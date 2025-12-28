<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            // Logo: nullable permite que sea opcional. Ajustado a lo que envía el Cropper.
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=800,max_height=800|max:512',

            'company_type_id'        => 'required|exists:company_types,id',
            'company_name'           => 'required|unique:companies,company_name',
            'identification_type_id' => 'required|exists:document_types,id',
            'identification_number'  => 'required|unique:companies,identification_number',
            'province_id'            => 'required|exists:provinces,id',
            'city_id'                => 'required|exists:cities,id',
            'industry_type_id'       => 'required|exists:industries,id',
            'size'                   => 'required|numeric|min:1',
            'founded_at'             => 'required|date|before:today',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            // Validación del Logo
            'logo.image'              => 'El archivo seleccionado debe ser una imagen.',
            'logo.mimes'              => 'El logo debe estar en formato jpeg, png o jpg.',
            'logo.dimensions'         => 'La imagen procesada es demasiado grande (máximo 800x800 píxeles).',
            'logo.max'                => 'El archivo del logo no debe pesar más de 512KB.',

            // Información de la Empresa
            'company_type_id.required' => 'Debes seleccionar un tipo de empresa.',
            'company_type_id.exists'   => 'El tipo de empresa seleccionado no es válido.',

            'company_name.required'    => 'El nombre de la empresa es obligatorio.',
            'company_name.unique'      => 'Este nombre de empresa ya se encuentra registrado.',

            // Identificación
            'identification_type_id.required' => 'El tipo de identificación es obligatorio.',
            'identification_type_id.exists'   => 'El tipo de identificación seleccionado no es válido.',

            'identification_number.required'  => 'El número de identificación (NIT/CC) es obligatorio.',
            'identification_number.unique'    => 'Este número de identificación ya está vinculado a otra empresa.',

            // Ubicación y Sector
            'province_id.required'     => 'El departamento es obligatorio.',
            'province_id.exists'       => 'El departamento seleccionado no existe en nuestros registros.',

            'city_id.required'         => 'El municipio/ciudad es obligatorio.',
            'city_id.exists'           => 'El municipio seleccionado no es válido.',

            'industry_type_id.required' => 'Debes seleccionar el sector o industria.',
            'industry_type_id.exists'   => 'El sector seleccionado no es válido.',

            // Datos Numéricos y Fechas
            'size.required'            => 'La cantidad de empleados es obligatoria.',
            'size.numeric'             => 'La cantidad de empleados debe ser un valor numérico.',
            'size.min'                 => 'La cantidad de empleados debe ser al menos 1.',

            'founded_at.required'      => 'La fecha de fundación es obligatoria.',
            'founded_at.date'          => 'La fecha de fundación no tiene un formato válido.',
            'founded_at.before'        => 'La fecha de fundación no puede ser una fecha futura.',
        ];
    }
}
