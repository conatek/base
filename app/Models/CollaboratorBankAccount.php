<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollaboratorBankAccount extends Model
{
    protected $table = 'collaborator_bank_accounts';

    protected $fillable = [
        'collaborator_id',
        'bank_id',
        'bank_account_type_id',
        'bank_account',
        'bank_certificate_public_id',
        'bank_certificate_url',
        'observations',
    ];

    public function bank()
    {
        return $this->belongsTo(BankType::class, 'bank_id');
    }

    public function accountType()
    {
        return $this->belongsTo(BankAccountType::class, 'bank_account_type_id');
    }
}
