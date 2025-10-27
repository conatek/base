<?php

namespace App\Http\Requests;

use App\Models\CollaboratorContract;
use App\Models\ContractType;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CollaboratorContractCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'position_id'          => 'required|integer',
            'salary'               => 'required|numeric|min:0',
            'contract_type_id'     => 'required|integer',
            'contract_start_date'  => 'required|date',
            'contract_end_date'    => 'nullable|date|after_or_equal:contract_start_date',
            'test_period_end_date' => 'required|date|after_or_equal:contract_start_date',

            // 'bank_id'              => 'required|integer',
            // 'bank_account'         => 'required|string',
            // 'eps_id'               => 'required|integer',
            // 'afp_pension_id'       => 'required|integer',
            // 'afp_saving_id'        => 'required|integer',
            // 'arl_id'               => 'required|integer',
            // 'ccf_id'               => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'position_id.required' => 'El cargo es requerido.',
            'position_id.integer'  => 'El cargo debe ser un número entero.',
            'salary.required' => 'El salario es requerido.',
            'salary.numeric' => 'El salario debe ser un número.',
            'salary.min'     => 'El salario no puede ser negativo.',
            'contract_type_id.required' => 'El tipo de contrato es requerido.',
            'contract_type_id.integer'  => 'El tipo de contrato debe ser un número entero.',
            'contract_start_date.required' => 'La fecha de inicio de contrato es requerida.',
            'contract_start_date.date'     => 'La fecha de inicio de contrato no es una fecha válida.',
            'contract_end_date.date'       => 'La fecha de fin de contrato no es una fecha válida.',
            'contract_end_date.after_or_equal' => 'La fecha de fin de contrato debe ser igual o posterior a la fecha de inicio.',
            'test_period_end_date.required' => 'La fecha de fin de periodo de prueba es requerida.',
            'test_period_end_date.date'     => 'La fecha de fin de periodo de prueba no es una fecha válida.',
            'test_period_end_date.after_or_equal' => 'La fecha de fin de periodo de prueba debe ser igual o posterior a la fecha de inicio.',
            // 'corporate_email.required' => 'El correo corporativo es requerido.',
            // 'corporate_cellphone.required' => 'El celular corporativo es requerido.',
            // 'bank_id.required' => 'El banco es requerido.',
            // 'bank_id.integer'  => 'El banco debe ser un número entero.',
            // 'bank_account.required' => 'La cuenta bancaria es requerida.',
            // 'bank_account.string'   => 'La cuenta bancaria debe ser una cadena de texto.',
            // 'eps_id.required' => 'La EPS es requerida.',
            // 'eps_id.integer'  => 'La EPS debe ser un número entero.',
            // 'afp_pension_id.required' => 'La AFP de pensiones es requerida.',
            // 'afp_pension_id.integer'  => 'La AFP de pensiones debe ser un número entero.',
            // 'afp_saving_id.required' => 'La AFP de cesantías es requerida.',
            // 'afp_saving_id.integer'  => 'La AFP de cesantías debe ser un número entero.',
            // 'arl_id.required' => 'La ARL es requerida.',
            // 'arl_id.integer'  => 'La ARL debe ser un número entero.',
            // 'ccf_id.required' => 'La caja de compensación familiar es requerida.',
            // 'ccf_id.integer'  => 'La caja de compensación familiar debe ser un número entero.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            // Si ya hay errores de date/required, no continúes
            if ($v->errors()->isNotEmpty()) {
                return;
            }

            // 1) Identificadores
            $collaboratorId = $this->input('collaborator_id');
            if (!$collaboratorId) {
                $v->errors()->add('collaborator_id', 'No se pudo determinar el colaborador.');
                return;
            }

            // En creación normalmente no hay contractId
            $contractId = $this->route('contract') ?? $this->input('id');
            $contractId = $contractId ? (int) $contractId : null;

            // 2) Fechas (ya validadas como date por rules)
            $start = Carbon::parse($this->input('contract_start_date'))->startOfDay();
            $end   = $this->filled('contract_end_date')
                ? Carbon::parse($this->input('contract_end_date'))->endOfDay()
                : null;

            // 3) Política de borde: ¿permitir que un contrato termine el mismo día que el otro inicia?
            $allowTouching = true; // ← cámbialo según tu negocio

            // 4) Solape
            $overlaps = \App\Models\CollaboratorContract::overlapsFor(
                $collaboratorId,
                $start,
                $end,
                $contractId,
                $allowTouching
            );

            if ($overlaps) {
                $v->errors()->add(
                    'contract_start_date',
                    'El rango de fechas se solapa con otro contrato del colaborador.'
                );
            }

            // 5) Validación específica del período de prueba según ley colombiana
            $this->validateTestPeriod($v);
        });
    }

    /**
     * Valida que el período de prueba cumpla con la normativa colombiana
     */
    protected function validateTestPeriod($validator)
    {
        $contractStartDate = Carbon::parse($this->input('contract_start_date'));
        $testPeriodEndDate = Carbon::parse($this->input('test_period_end_date'));
        $contractEndDate = $this->filled('contract_end_date')
            ? Carbon::parse($this->input('contract_end_date'))
            : null;

        $contractTypeId = $this->input('contract_type_id');

        // Obtener información del tipo de contrato
        $contractType = ContractType::find($contractTypeId);

        if (!$contractType) {
            $validator->errors()->add('contract_type_id', 'Tipo de contrato no válido.');
            return;
        }

        // Calcular la duración máxima permitida para el período de prueba
        $maxTestPeriod = $this->calculateMaxTestPeriod($contractStartDate, $contractEndDate, $contractType);

        if ($maxTestPeriod === null) {
            $validator->errors()->add('test_period_end_date', 'No se pudo calcular el período de prueba máximo para este tipo de contrato.');
            return;
        }

        // Calcular la duración real del período de prueba en días
        $actualTestPeriodDays = $contractStartDate->diffInDays($testPeriodEndDate);

        // Validar que no exceda el máximo permitido
        if ($actualTestPeriodDays > $maxTestPeriod) {
            $validator->errors()->add(
                'test_period_end_date',
                "El período de prueba no puede exceder los $maxTestPeriod días según la ley colombiana para este tipo de contrato."
            );
        }
    }

    /**
     * Calcula la duración máxima permitida para el período de prueba según la ley colombiana
     */
    protected function calculateMaxTestPeriod($startDate, $endDate, $contractType)
    {
        // Contratos a término indefinido: máximo 2 meses (60 días)
        if ($contractType->id === 3) { // ID 3 es término indefinido
            return 60;
        }

        // Contratos a término fijo: depende de la duración del contrato
        if ($endDate) {
            $contractDurationDays = $startDate->diffInDays($endDate);
            $contractDurationMonths = $startDate->diffInMonths($endDate);

            // Si el contrato es menor a 1 año (365 días)
            if ($contractDurationDays < 365) {
                // Máximo 1/5 de la duración del contrato (en días)
                $maxDays = floor($contractDurationDays / 5);

                // Pero nunca más de 60 días
                return min($maxDays, 60);
            } else {
                // Contratos de 1 año o más: máximo 60 días
                return 60;
            }
        }

        // Contratos por obra o labor: similar a término fijo
        // (Necesitarías lógica adicional para determinar la duración estimada)

        return null;
    }
}
