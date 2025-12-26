<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'staff_provider_id',
        'name',
        'first_surname',
        'second_surname',
        'document_type_id',
        'document_number',
        'document_province_id',
        'document_city_id',
        'expedition_date',
        'birth_province_id',
        'birth_city_id',
        'birth_date',
        'is_foreigner',
        'civil_status_type_id',
        'sex_type_id',
        'rh_type_id',
        'scholarship_type_id',
        'observations',
        'residence_province_id',
        'residence_city_id',
        'housing_tenure_id',
        'stratum_type_id',
        'address',
        'phone',
        'cellphone',
        'email',
        'image_public_id',
        'image_url',
        'is_active',
    ];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function document_province()
    {
        return $this->belongsTo(Province::class);
    }

    public function document_city()
    {
        return $this->belongsTo(City::class);
    }

    public function birth_province()
    {
        return $this->belongsTo(Province::class, 'birth_province_id');
    }

    public function birth_city()
    {
        return $this->belongsTo(City::class, 'birth_city_id');
    }

    public function residence_province()
    {
        return $this->belongsTo(Province::class, 'residence_province_id');
    }

    public function residence_city()
    {
        return $this->belongsTo(City::class, 'residence_city_id');
    }

    public function stratum_type()
    {
        return $this->belongsTo(SocialStratum::class);
    }

    public function civil_status_type()
    {
        return $this->belongsTo(CivilStatusType::class);
    }

    public function highest_academic_achievement(): HasOne
    {
        // 'ofMany' recibirá la columna a comparar y la función agregada ('max')
        return $this->hasOne(CollaboratorAcademicAchievement::class)
            ->ofMany('achievement_type_id', 'max');
    }

    public function sex_type()
    {
        return $this->belongsTo(SexType::class);
    }

    public function rh_type()
    {
        return $this->belongsTo(RhType::class);
    }

    public function staff_provider()
    {
        return $this->belongsTo(StaffProvider::class);
    }

    public function social_security()
    {
        return $this->hasOne(CollaboratorSocialSecurity::class);
    }

    public function bank_accounts()
    {
        return $this->hasMany(CollaboratorBankAccount::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(CollaboratorContract::class);
    }

    public function activeContract(): HasOne
    {
        // Usa el scope 'active' y fija un orden determinista
        return $this->hasOne(CollaboratorContract::class)
            ->active()                     // scope (ver abajo)
            ->latest('contract_start_date');
    }

    public function hasActiveContract(?Carbon $on = null): bool
    {
        return $this->contracts()->active($on)->exists();
    }

    public function getActiveContract(?Carbon $on = null): ?CollaboratorContract
    {
        return $this->contracts()->active($on)
            ->latest('contract_start_date')
            ->first();
    }

    public function position()
    {
        return $this->hasOneThrough(
            Position::class,
            CollaboratorContract::class,
            'collaborator_id', // Llave foránea en collaborator_contracts
            'id', // Llave primaria en positions
            'id', // Llave primaria en collaborators
            'position_id' // Llave foránea en collaborator_contracts
        );
    }
}
