<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Cargos base por tipo de área
        $positionCatalog = [
            'Comercial' => ['Ejecutivo de Ventas', 'Gerente Comercial', 'Analista de Ventas'],
            'Operaciones' => ['Coordinador de Operaciones', 'Supervisor Operativo', 'Analista de Procesos'],
            'Investigación y Desarrollo' => ['Investigador', 'Coordinador de I+D', 'Ingeniero de Desarrollo'],
            'Talento Humano' => ['Analista de Talento Humano', 'Jefe de RRHH', 'Coordinador de Selección'],
            'Tecnología' => ['Desarrollador Backend', 'Administrador de Sistemas', 'Ingeniero de Soporte'],
            'Logística' => ['Coordinador de Logística', 'Auxiliar Logístico', 'Planeador de Rutas'],
            'Servicio al Cliente' => ['Representante de Atención', 'Jefe de Servicio', 'Asesor de Clientes'],
            'Finanzas' => ['Contador', 'Analista Financiero', 'Coordinador de Tesorería'],
            'Mercadeo' => ['Diseñador Gráfico', 'Community Manager', 'Especialista en Marketing'],
            'Calidad' => ['Auditor Interno', 'Coordinador de Calidad', 'Inspector de Calidad'],
        ];

        // Traer todas las áreas
        $areas = DB::table('areas')->get();

        foreach ($areas as $area) {
            $positionNames = $positionCatalog[$area->name] ?? [
                'Asistente', 'Coordinador', 'Analista'
            ];

            // Seleccionar aleatoriamente 2 cargos distintos
            $selectedPositions = collect($positionNames)->random(2);

            foreach ($selectedPositions as $positionName) {
                DB::table('positions')->insert([
                    'company_id' => 1,
                    'area_id' => $area->id,
                    'criticality_level_id' => rand(1, 3),
                    'risk_class_id' => rand(1, 5),
                    'name' => $positionName,
                    'estimated_salary' => rand(1200000, 8000000),
                    'description' => "Cargo de $positionName en el área {$area->name}.",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}

