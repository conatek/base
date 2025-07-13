<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Module::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $modules = [
            ['name' => 'home', 'display_name' => 'Inicio'], // Module 1
            ['name' => 'companies', 'display_name' => 'Empresas'], // Module 2
            ['name' => 'roles', 'display_name' => 'Roles'], // Module 3
            ['name' => 'permissions', 'display_name' => 'Permisos'], // Module 4
            ['name' => 'users', 'display_name' => 'Usuarios'], // Module 5
            ['name' => 'company', 'display_name' => 'Organización'], // Module 6
            ['name' => 'locations', 'display_name' => 'Sedes'], // Module 7
            ['name' => 'areas', 'display_name' => 'Áreas'], // Module 8
            ['name' => 'positions', 'display_name' => 'Cargos'], // Module 9
            ['name' => 'collaborators', 'display_name' => 'Colaboradores'], // Module 10
        ];

        foreach ($modules as $module) {
            Module::create([
                'name' => $module['name'],
                'display_name' => $module['display_name'],
            ]);
        }
    }
}
