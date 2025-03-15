<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'area_id',
        'criticality_level_id',
        'risk_class_id',
        'estimated_salary',
        'description',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function contracts()
    {
        return $this->hasMany(CollaboratorContract::class);
    }

    public function collaborators()
    {
        return $this->hasManyThrough(
            Collaborator::class,
            CollaboratorContract::class,
            'position_id', // Llave foránea en collaborator_contracts
            'id', // Llave primaria en collaborators
            'id', // Llave primaria en positions
            'collaborator_id' // Llave foránea en collaborator_contracts
        );
    }
}
