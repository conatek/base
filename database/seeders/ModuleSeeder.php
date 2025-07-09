<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['name' => 'home', 'display_name' => 'Inicio'],
            ['name' => 'permissions', 'display_name' => 'Permisos'],
            ['name' => 'roles', 'display_name' => 'Roles'],
            ['name' => 'users', 'display_name' => 'Usuarios'],
            ['name' => 'companies', 'display_name' => 'Compañías'],
            ['name' => 'locations', 'display_name' => 'Sedes'],
            ['name' => 'areas', 'display_name' => 'Áreas'],
            ['name' => 'positions', 'display_name' => 'Cargos'],
            ['name' => 'collaborators', 'display_name' => 'Colaboradores'],
        ];

        foreach ($modules as $module) {
            Module::create([
                'name' => $module['name'],
                'display_name' => $module['display_name'],
            ]);
        }
    }
}
