<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AbsenceType;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'is_extension',
        'parent_absence_id',
        'absence_type_id',
        'absence_subtype',
        'disease_classification_code',
        'description',
        'start_date',
        'end_date',
        'hours',
        'days',
        'support_file_public_id',
        'support_file_url',
        'observations',
        'created_at',
        'updated_at',
    ];

    public function absenceType()
    {
        return $this->belongsTo(AbsenceType::class, 'absence_type_id', 'id');
    }

    public function segment()
    {
        return $this->belongsTo(DiseaseClassification::class, 'disease_classification_code', 'cie_code');
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'collaborator_id', 'id');
    }

    public function collaboratorContract()
    {
        return $this->hasOne(CollaboratorContract::class, 'collaborator_id', 'collaborator_id');
    }

    public function absenceStatus()
    {
        return $this->hasOne(AbsenceStatus::class, 'absence_id', 'id');
    }

}
