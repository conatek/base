<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Lista de nombres de áreas funcionales
        $areaNames = [
            'Comercial',
            'Operaciones',
            'Investigación y Desarrollo',
            'Talento Humano',
            'Tecnología',
            'Logística',
            'Servicio al Cliente',
            'Finanzas',
            'Mercadeo',
            'Calidad'
        ];

        // Obtener todos los campuses
        $campuses = DB::table('campuses')->where('company_id', 1)->get();

        // Obtener IDs de líderes disponibles (colaborators)
        $leaders = DB::table('collaborators')->where('company_id', 1)->pluck('id')->toArray();

        if (empty($leaders)) {
            $this->command->warn('No hay colaboradores disponibles como líderes.');
            return;
        }

        foreach ($campuses as $campus) {
            // Seleccionar aleatoriamente 3 áreas diferentes por campus
            $selectedAreas = collect($areaNames)->random(3);

            foreach ($selectedAreas as $areaName) {
                DB::table('areas')->insert([
                    'company_id' => $campus->company_id,
                    'campus_id' => $campus->id,
                    'leader_id' => fake()->randomElement($leaders),
                    'name' => $areaName,
                    'description' => "Área de $areaName en la sede {$campus->name}.",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}

