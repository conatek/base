<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollaboratorBankAccountCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'bank_id'              => 'required|integer|exists:bank_types,id',
            'bank_account_type_id' => 'required|integer|exists:bank_account_types,id',
            'bank_account'         => 'required|string',
        ];

        if ($this->hasFile('bank_account_file')) {
            $rules['bank_account_file'] = 'max:2048|mimes:pdf';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'bank_id.required' => 'El banco es requerido.',
            'bank_id.integer'  => 'El banco debe ser un número entero.',
            'bank_account_type_id.required' => 'El tipo de cuenta es requerido.',
            'bank_account_type_id.exists'   => 'El tipo de cuenta seleccionado no es válido.',
            'bank_account.required' => 'La número de cuenta es requerido.',
            'bank_account.string'   => 'La cuenta bancaria debe ser una cadena de texto.',
            'bank_account_file.max' => 'El certificado no debe ser mayor a 2MB.',
            'bank_account_file.mimes' => 'El certificado debe ser un PDF.',
        ];
    }
}
