<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollaboratorAcademicAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'achievement_type_id',
        'degree',
        'institution',
        'end_date',
        'occupation_id',
        'certificate_public_id',
        'certificate_url',
    ];

    public function achievement_type(): BelongsTo
    {
        return $this->belongsTo(AcademicAchievementType::class, 'achievement_type_id');
    }

    public function collaborator(): BelongsTo
    {
        return $this->belongsTo(Collaborator::class);
    }
}
