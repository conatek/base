<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            ['name' => 'block_company', 'module_id' => 1, 'display_name' => 'Bloque de Gestión de Empresa'],
            ['name' => 'block_collaborators', 'module_id' => 1, 'display_name' => 'Bloque de Gestión de Colaboradores'],
            ['name' => 'block_self_management', 'module_id' => 1, 'display_name' => 'Bloque de Autogestión'],
            ['name' => 'block_utilities', 'module_id' => 1, 'display_name' => 'Bloque de Utilidades'],
            ['name' => 'home_index', 'module_id' => 1, 'display_name' => 'Home'],

            ['name' => 'companies_index', 'module_id' => 2, 'display_name' => 'Listar Empresas'],
            ['name' => 'companies_create', 'module_id' => 2, 'display_name' => 'Crear Empresas'],
            ['name' => 'companies_show', 'module_id' => 2, 'display_name' => 'Ver Empresas'],
            ['name' => 'companies_edit', 'module_id' => 2, 'display_name' => 'Editar Empresas'],
            ['name' => 'companies_destroy', 'module_id' => 2, 'display_name' => 'Eliminar Empresas'],

            ['name' => 'roles_index', 'module_id' => 3, 'display_name' => 'Roles'],
            ['name' => 'roles_create', 'module_id' => 3, 'display_name' => 'Crear Roles'],
            ['name' => 'roles_show', 'module_id' => 3, 'display_name' => 'Mostrar Roles'],
            ['name' => 'roles_edit', 'module_id' => 3, 'display_name' => 'Editar Roles'],
            ['name' => 'roles_destroy', 'module_id' => 3, 'display_name' => 'Eliminar Roles'],

            ['name' => 'permissions_index', 'module_id' => 4, 'display_name' => 'Permisos'],
            ['name' => 'permissions_create', 'module_id' => 4, 'display_name' => 'Crear Permisos'],
            ['name' => 'permissions_show', 'module_id' => 4, 'display_name' => 'Mostrar Permisos'],
            ['name' => 'permissions_edit', 'module_id' => 4, 'display_name' => 'Editar Permisos'],
            ['name' => 'permissions_destroy', 'module_id' => 4, 'display_name' => 'Eliminar Permisos'],

            ['name' => 'users_index', 'module_id' => 5, 'display_name' => 'Listar Usuarios'],
            ['name' => 'users_create', 'module_id' => 5, 'display_name' => 'Crear Usuarios'],
            ['name' => 'users_show', 'module_id' => 5, 'display_name' => 'Ver Usuarios'],
            ['name' => 'users_edit', 'module_id' => 5, 'display_name' => 'Editar Usuarios'],
            ['name' => 'users_destroy', 'module_id' => 5, 'display_name' => 'Eliminar Usuarios'],

            ['name' => 'company_index', 'module_id' => 6, 'display_name' => 'Organización'],

            ['name' => 'campus_index', 'module_id' => 7, 'display_name' => 'Listar Sedes'],
            ['name' => 'campus_create', 'module_id' => 7, 'display_name' => 'Crear Sedes'],
            ['name' => 'campus_show', 'module_id' => 7, 'display_name' => 'Ver Sedes'],
            ['name' => 'campus_edit', 'module_id' => 7, 'display_name' => 'Editar Sedes'],
            ['name' => 'campus_destroy', 'module_id' => 7, 'display_name' => 'Eliminar Sedes'],

            ['name' => 'areas_index', 'module_id' => 8, 'display_name' => 'Listar Áreas'],
            ['name' => 'areas_create', 'module_id' => 8, 'display_name' => 'Crear Áreas'],
            ['name' => 'areas_show', 'module_id' => 8, 'display_name' => 'Ver Áreas'],
            ['name' => 'areas_edit', 'module_id' => 8, 'display_name' => 'Editar Áreas'],
            ['name' => 'areas_destroy', 'module_id' => 8, 'display_name' => 'Eliminar Áreas'],

            ['name' => 'positions_index', 'module_id' => 9, 'display_name' => 'Listar Cargos'],
            ['name' => 'positions_create', 'module_id' => 9, 'display_name' => 'Crear Cargos'],
            ['name' => 'positions_show', 'module_id' => 9, 'display_name' => 'Ver Cargos'],
            ['name' => 'positions_edit', 'module_id' => 9, 'display_name' => 'Editar Cargos'],
            ['name' => 'positions_destroy', 'module_id' => 9, 'display_name' => 'Eliminar Cargos'],

            ['name' => 'collaborators_index', 'module_id' => 10, 'display_name' => 'Listar Colaboradores'],
            ['name' => 'collaborators_create', 'module_id' => 10, 'display_name' => 'Crear Colaboradores'],
            ['name' => 'collaborators_show', 'module_id' => 10, 'display_name' => 'Ver Colaboradores'],
            ['name' => 'collaborators_edit', 'module_id' => 10, 'display_name' => 'Editar Colaboradores'],
            ['name' => 'collaborators_destroy', 'module_id' => 10, 'display_name' => 'Eliminar Colaboradores'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'module_id' => $permission['module_id'],
                'display_name' => $permission['display_name'],
                'guard_name' => 'web',
            ]);
        }
    }
}
