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
        if($this->request->get('bank_account_file') != null){
            return [
                'bank_id'              => 'required|integer',
                'bank_account'         => 'required|string',
                'bank_account_file'    => 'max:2048|mimes:pdf',
            ];
        } else {
            return [
                'bank_id'              => 'required|integer',
                'bank_account'         => 'required|string',
            ];
        }
    }

    public function messages(): array
    {
        return [
            'bank_id.required' => 'El banco es requerido.',
            'bank_id.integer'  => 'El banco debe ser un número entero.',
            'bank_account.required' => 'La número de cuenta es requerido.',
            'bank_account.string'   => 'La cuenta bancaria debe ser una cadena de texto.',
            'bank_account_file.max' => 'El certificado no debe ser mayor a 2MB.',
            'bank_account_file.mimes' => 'El certificado debe ser un PDF.',
        ];
    }
}
