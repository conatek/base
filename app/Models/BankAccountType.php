<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccountType extends Model
{
    use HasFactory;

    protected $table = 'bank_account_types';

    protected $fillable = [
        'name',
    ];

    // Relación: Un tipo de cuenta puede estar en muchas cuentas de colaboradores
    public function collaboratorBankAccounts()
    {
        return $this->hasMany(CollaboratorBankAccount::class, 'bank_account_type_id');
    }
}
