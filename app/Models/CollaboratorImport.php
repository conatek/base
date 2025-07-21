<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaboratorImport extends Model
{
    protected $table = 'tmp_collaborator_imports';

    protected $fillable = [
        'company_id',
        'document_type',
        'document_number',
        'expedition_date',
        'document_province',
        'document_city',
        'name',
        'first_surname',
        'second_surname',
        'civil_status_type',
        'sex_type',
        'rh_type',
        'birth_date',
        'birth_province',
        'birth_city',
        'residence_province',
        'residence_city',
        'address',
        'housing_tenure',
        'stratum_type',
        'phone',
        'cellphone',
        'email',
        'observations',
        'hash',
    ];

    public $timestamps = false;

}
