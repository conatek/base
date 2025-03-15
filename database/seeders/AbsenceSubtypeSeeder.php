<?php

namespace Database\Seeders;

use App\Models\AbsenceSubtype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenceSubtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AbsenceSubtype::create(['absence_type_id' => 6, 'subtype' => 'Consulta programada por la empresa en entidad diferente a la EPS']);
        AbsenceSubtype::create(['absence_type_id' => 6, 'subtype' => 'Consulta programada por el colaborador en la EPS']);
        AbsenceSubtype::create(['absence_type_id' => 6, 'subtype' => 'Consulta odontológica (sea o no programada por la EPS)']);
        AbsenceSubtype::create(['absence_type_id' => 6, 'subtype' => 'Ayudas diagnósticas (sea o no programada por la EPS)']);
        AbsenceSubtype::create(['absence_type_id' => 6, 'subtype' => 'Exámenes médicos en la ARL']);

        AbsenceSubtype::create(['absence_type_id' => 7, 'subtype' => 'Permiso remunerado']);
        AbsenceSubtype::create(['absence_type_id' => 7, 'subtype' => 'Permiso no remunerado']);
        AbsenceSubtype::create(['absence_type_id' => 7, 'subtype' => 'Suspensión']);

        AbsenceSubtype::create(['absence_type_id' => 8, 'subtype' => 'Ausencia justificada']);
        AbsenceSubtype::create(['absence_type_id' => 8, 'subtype' => 'Ausencia no justificada']);
        AbsenceSubtype::create(['absence_type_id' => 8, 'subtype' => 'Calamidad doméstica']);
        AbsenceSubtype::create(['absence_type_id' => 8, 'subtype' => 'Permiso por productividad']);
        AbsenceSubtype::create(['absence_type_id' => 8, 'subtype' => 'Permiso escolar']);
    }
}
