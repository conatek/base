<?php

namespace Database\Seeders;

use App\Models\AbsenceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AbsenceType::create(['type' => 'Enfermedad común']);
        AbsenceType::create(['type' => 'Enfermedad laboral']);
        AbsenceType::create(['type' => 'Accidente de trabajo']);
        AbsenceType::create(['type' => 'Accidente de tránsito']);
        AbsenceType::create(['type' => 'Maternidad/Paternidad']);
        AbsenceType::create(['type' => 'Cita médica']);
        AbsenceType::create(['type' => 'Causa legal']);
        AbsenceType::create(['type' => 'Causa extralegal']);
    }
}
