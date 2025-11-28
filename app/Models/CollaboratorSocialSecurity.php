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

    public function eps()
    {
        return $this->belongsTo(EpsType::class, 'eps_id');
    }

    public function afp_pension()
    {
        return $this->belongsTo(AfpType::class, 'afp_pension_id');
    }

    public function afp_saving()
    {
        return $this->belongsTo(AfpType::class, 'afp_saving_id');
    }

    public function arl()
    {
        return $this->belongsTo(ArlType::class, 'arl_id');
    }

    public function ccf()
    {
        return $this->belongsTo(CcfType::class, 'ccf_id');
    }
}
