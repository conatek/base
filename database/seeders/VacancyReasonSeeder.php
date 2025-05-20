<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacancyReasonSeeder extends Seeder
{
    public function run(): void
    {
        $reasons = [
            'Reemplazo por retiro',
            'Reemplazo por licencia prolongada',
            'Creación de nuevo cargo',
            'Ampliación del equipo',
            'Cambio de ubicación del colaborador',
            'Promoción interna',
        ];

        foreach ($reasons as $reason) {
            DB::table('vacancy_reasons')->updateOrInsert(['name' => $reason]);
        }
    }
}
