<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CollaboratorsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $collaborators;

    public function __construct($collaborators)
    {
        $this->collaborators = $collaborators;
    }

    public function collection()
    {
        return $this->collaborators;
    }

    public function headings(): array
    {
        return [
            'Proveedor',
            'Nombre Completo',
            'Tipo Documento',
            'Número Documento',
            'Fecha de Expedición',
            'Departamento de Expedición',
            'Ciudad de Expedición',
            'Estado Civil',
            'Género',
            'RH',
            'Fecha de Nacimiento',
            'Departamento de Nacimiento',
            'Ciudad de Nacimiento',
            'Departamento de Residencia',
            'Ciudad de Residencia',
            'Dirección de Residencia',
            'Tenencia de Vivienda',
            'Estrato',
            'Teléfono',
            'Celular',
            'Correo Electrónico',
            'Estado Activo',
            'Sede',
            'Área',
            'Líder de Área',
            'Tipo de Contrato',
            'Cargo',
            'Nivel de Criticidad',
            'Nivel de Riesgo',
            'Fecha de Inicio de Contrato',
            'Fecha de Fin de Contrato',
            'Fecha de Fin de Prueba',
            'Salario Mensual',
            'EPS',
            'AFP Pensión',
            'AFP Cesantías',
            'ARL',
            'Caja de Compensación Familiar',
            'Banco',
            'Número de Cuenta',
            'Tipo de Cuenta',
            'Observaciones',
        ];
    }

    /**
    * @var Collaborator $collaborator
    */
    public function map($collaborator): array
    {
        return [
            $collaborator->staff_provider->name ?? 'N/A',
            $collaborator->name . ' ' . $collaborator->first_surname . ($collaborator->second_surname ? ' ' . $collaborator->second_surname : ''),
            $collaborator->document_type->type ?? 'N/A',
            $collaborator->document_number,
            $collaborator->expedition_date ? Carbon::parse($collaborator->expedition_date)->format('Y-m-d') : 'N/A',
            $collaborator->document_province->name ?? 'N/A',
            $collaborator->document_city->name ?? 'N/A',
            $collaborator->civil_status_type->type ?? 'N/A',
            $collaborator->sex_type->name ?? 'N/A',
            $collaborator->rh_type->name ?? 'N/A',
            $collaborator->birth_date ? Carbon::parse($collaborator->birth_date)->format('Y-m-d') : 'N/A',
            $collaborator->birth_province->name ?? 'N/A',
            $collaborator->birth_city->name ?? 'N/A',
            $collaborator->residence_province->name ?? 'N/A',
            $collaborator->residence_city->name ?? 'N/A',
            $collaborator->address ?? 'N/A',
            $collaborator->housing_tenure->type ?? 'N/A',
            $collaborator->stratum_type->name ? '[' . $collaborator->stratum_type->id . '] ' . $collaborator->stratum_type->name : 'N/A',
            $collaborator->phone ?? 'N/A',
            $collaborator->cellphone ?? 'N/A',
            $collaborator->email ?? 'N/A',
            $collaborator->is_active ? 'Sí' : 'No',
            $collaborator->activeContract->position->area->campus->name ?? 'N/A',
            $collaborator->activeContract->position->area->name ?? 'N/A',
            $collaborator->activeContract->position->area->leader ? $collaborator->activeContract->position->area->leader->name . ' ' . $collaborator->activeContract->position->area->leader->first_surname : 'N/A',
            $collaborator->activeContract->contract_type->name ?? 'N/A',
            $collaborator->activeContract->position->name ?? 'N/A',
            $collaborator->activeContract->position->position_criticality_level->level ? '[' . $collaborator->activeContract->position->position_criticality_level->id . '] ' . $collaborator->activeContract->position->position_criticality_level->level . ' - ' . $collaborator->activeContract->position->position_criticality_level->description : 'N/A',
            $collaborator->activeContract->position->position_risk_class->class ? '[' . $collaborator->activeContract->position->position_risk_class->class . '] ' . $collaborator->activeContract->position->position_risk_class->description : 'N/A',
            $collaborator->activeContract->contract_start_date ? Carbon::parse($collaborator->activeContract->contract_start_date)->format('Y-m-d') : 'N/A',
            $collaborator->activeContract->contract_end_date ? Carbon::parse($collaborator->activeContract->contract_end_date)->format('Y-m-d') : 'N/A',
            $collaborator->activeContract->test_period_end_date ? Carbon::parse($collaborator->activeContract->test_period_end_date)->format('Y-m-d') : 'N/A',
            $collaborator->activeContract->salary ? number_format($collaborator->activeContract->salary) : 'N/A',
            $collaborator->social_security->eps->name ?? 'N/A',
            $collaborator->social_security->afp_pension->name ?? 'N/A',
            $collaborator->social_security->afp_saving->name ?? 'N/A',
            $collaborator->social_security->arl->name ?? 'N/A',
            $collaborator->social_security->ccf->name ?? 'N/A',
            $collaborator->bank_account->bank->name ?? 'N/A',
            $collaborator->bank_account->bank_account ?? 'N/A',
            $collaborator->bank_account->accountType->name ?? 'N/A',
            $collaborator->observations ?? 'N/A',
        ];
    }
}
