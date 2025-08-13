<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffProvider extends Model
{
    protected $fillable = [
        'company_id',
        'provider_type_id',
        'name',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_cellphone',
        'province_id',
        'city_id',
        'address',
        'website',
        'observations',
    ];

    public function providerType()
    {
        return $this->belongsTo(ProviderType::class);
    }
}
