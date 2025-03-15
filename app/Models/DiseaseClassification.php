<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseClassification extends Model
{
    use HasFactory;

    protected $table = 'disease_classifications';

    protected $fillable = [
        'cie_code',
        'description',
        'group',
        'segment',
    ];


}
