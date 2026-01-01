<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'name',
        'first_surname',
        'second_surname',
        'relationship_id',
        'sex_type_id',
        'occupation_id',
        'birth_date'
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
    }

    public function sex_type()
    {
        return $this->belongsTo(SexType::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }
}
