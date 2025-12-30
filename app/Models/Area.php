<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'campus_id',
        'leader_id',
        'name',
        'description',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function leader()
    {
        return $this->belongsTo(Collaborator::class, 'leader_id');
    }
}
