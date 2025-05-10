<?php

namespace Database\Seeders;

use App\Models\AbsenceStatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenceStatusTypesSeeder extends Seeder
{
    public function run(): void
    {
        AbsenceStatusType::create(['type' => 'Pendiente']);
        AbsenceStatusType::create(['type' => 'Pagado']);
        AbsenceStatusType::create(['type' => 'Rechazado']);
    }
}
