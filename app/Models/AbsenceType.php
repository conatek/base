<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Absence;

class AbsenceType extends Model
{
    use HasFactory;

    public function absences()
    {
        return $this->hasMany(Absence::class, 'absence_type_id', 'id');
    }
}
