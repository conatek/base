<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('modules')->truncate();

        $modules = [
            ['name' => 'home',            'display_name' => 'Inicio'],                     // Module 1
            ['name' => 'companies',       'display_name' => 'Empresas'],                    // Module 2
            ['name' => 'roles',           'display_name' => 'Roles'],                       // Module 3
            ['name' => 'permissions',     'display_name' => 'Permisos'],                    // Module 4
            ['name' => 'users',           'display_name' => 'Usuarios'],                    // Module 5
            ['name' => 'company',         'display_name' => 'Organización'],                // Module 6
            ['name' => 'campus',          'display_name' => 'Sedes'],                       // Module 7
            ['name' => 'areas',           'display_name' => 'Áreas'],                       // Module 8
            ['name' => 'positions',       'display_name' => 'Cargos'],                      // Module 9
            ['name' => 'collaborators',   'display_name' => 'Colaboradores'],               // Module 10
            ['name' => 'selection',       'display_name' => 'Procesos de Selección'],       // Module 11
            ['name' => 'absence',         'display_name' => 'Ausentismo'],                  // Module 12
            ['name' => 'provision',       'display_name' => 'Dotación'],                    // Module 13
            ['name' => 'training',        'display_name' => 'Planes de Formación'],         // Module 14
            ['name' => 'performance',     'display_name' => 'Evaluación de Desempeño'],     // Module 15
            ['name' => 'wellness',        'display_name' => 'Bienestar'],                   // Module 16
            ['name' => 'self_management', 'display_name' => 'Autogestión'],                 // Module 17
            ['name' => 'tools',           'display_name' => 'Herramientas'],                // Module 18
        ];

        foreach ($modules as $module) {
            Module::create([
                'name'         => $module['name'],
                'display_name' => $module['display_name'],
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
