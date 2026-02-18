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
        'vacancies_count',
        'observations',
        'vacancy_reason_id',
        'requested_by_id',
        'approved_by_id',
        'approved_at',
        'approval_reason',
        'cancelled_by_id',
        'cancelled_at',
        'cancellation_reason',
        'replaces_id',
        'selection_source_id',
        'vacancy_status_id',
        'request_date',
        'closing_date',
        'vacancy_duration_days',
    ];

    public function requisition_type()
    {
        return $this->belongsTo(CollaboratorRequisitionType::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function vacancy_reason()
    {
        return $this->belongsTo(VacancyReason::class, 'vacancy_reason_id');
    }

    public function requested_by()
    {
        return $this->belongsTo(Collaborator::class, 'requested_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(Collaborator::class, 'approved_by_id');
    }

    public function cancelled_by()
    {
        return $this->belongsTo(Collaborator::class, 'cancelled_by_id');
    }

    public function replaces()
    {
        return $this->belongsTo(Collaborator::class, 'replaces_id');
    }

    public function selection_source()
    {
        return $this->belongsTo(SelectionSource::class, 'selection_source_id');
    }

    public function vacancy_status()
    {
        return $this->belongsTo(VacancyStatus::class, 'vacancy_status_id');
    }
}
