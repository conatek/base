<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaboratorRequisition extends Model
{
    protected $fillable = [
        'company_id',
        'requisition_type_id',
        'area_id',
        'position_id',
        'vacancy_reason_id',
        'requested_by_id',
        'replaces_id',
        'vacancy_status_id',
        'request_date',
        'vacancies_count',
        'observations', // Asegúrate de agregar este campo en una migración si no existe en la tabla original
        // ... otros campos
    ];
}
