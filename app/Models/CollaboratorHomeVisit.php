<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorHomeVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'home_visit_type_id',
        'visit_date',
        'next_visit_date',
        'observations',
        'report_public_id',
        'report_url'
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function home_visit_type()
    {
        return $this->belongsTo(HomeVisitType::class);
    }
}
