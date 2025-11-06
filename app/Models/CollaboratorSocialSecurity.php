<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaboratorSocialSecurity extends Model
{
    protected $table = 'collaborator_social_securities';

    protected $fillable = [
        'collaborator_id',
        'eps_id',
        'eps_certificate_public_id',
        'eps_certificate_url',
        'afp_pension_id',
        'afp_pension_certificate_public_id',
        'afp_pension_certificate_url',
        'afp_saving_id',
        'afp_saving_certificate_public_id',
        'afp_saving_certificate_url',
        'arl_id',
        'ccf_id',
        'observations',
    ];
}
