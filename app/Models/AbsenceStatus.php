<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceStatus extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'absence_id',
        'absence_status_type_id',
        'authorized_value',
        'paid_value',
        'paid_days',
        'payment_date',
        'support_public_id',
        'support_url',
        'observations',
    ];

    public function absenceStatusType()
    {
        return $this->belongsTo(AbsenceStatusType::class, 'absence_status_type_id', 'id');
    }
}
