<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'home_master', 'module_id' => 1, 'display_name' => 'Home Master'],
            ['name' => 'home_super', 'module_id' => 1, 'display_name' => 'Home Super'],
            ['name' => 'home_admin', 'module_id' => 1, 'display_name' => 'Home Admin'],
            ['name' => 'home_generic', 'module_id' => 1, 'display_name' => 'Home Generic'],

            ['name' => 'permission_index', 'module_id' => 2, 'display_name' => 'Permisos'],
            ['name' => 'permission_create', 'module_id' => 2, 'display_name' => 'Crear Permisos'],
            ['name' => 'permission_show', 'module_id' => 2, 'display_name' => 'Mostrar Permisos'],
            ['name' => 'permission_edit', 'module_id' => 2, 'display_name' => 'Editar Permisos'],
            ['name' => 'permission_destroy', 'module_id' => 2, 'display_name' => 'Eliminar Permisos'],

            ['name' => 'role_index', 'module_id' => 3, 'display_name' => 'Roles'],
            ['name' => 'role_create', 'module_id' => 3, 'display_name' => 'Crear Roles'],
            ['name' => 'role_show', 'module_id' => 3, 'display_name' => 'Mostrar Roles'],
            ['name' => 'role_edit', 'module_id' => 3, 'display_name' => 'Editar Roles'],
            ['name' => 'role_destroy', 'module_id' => 3, 'display_name' => 'Eliminar Roles'],

            ['name' => 'user_index', 'module_id' => 4, 'display_name' => 'Listar Usuarios'],
            ['name' => 'user_create', 'module_id' => 4, 'display_name' => 'Crear Usuarios'],
            ['name' => 'user_show', 'module_id' => 4, 'display_name' => 'Ver Usuarios'],
            ['name' => 'user_edit', 'module_id' => 4, 'display_name' => 'Editar Usuarios'],
            ['name' => 'user_destroy', 'module_id' => 4, 'display_name' => 'Eliminar Usuarios'],

            ['name' => 'user_company_index', 'module_id' => 4, 'display_name' => 'Listar Usuarios de Compañía'],
            ['name' => 'user_company_create', 'module_id' => 4, 'display_name' => 'Crear Usuarios de Compañía'],
            ['name' => 'user_company_show', 'module_id' => 4, 'display_name' => 'Ver Usuarios de Compañía'],
            ['name' => 'user_company_edit', 'module_id' => 4, 'display_name' => 'Editar Usuarios de Compañía'],
            ['name' => 'user_company_destroy', 'module_id' => 4, 'display_name' => 'Eliminar Usuarios de Compañía'],

            ['name' => 'company_index', 'module_id' => 5, 'display_name' => 'Listar Compañías'],
            ['name' => 'company_create', 'module_id' => 5, 'display_name' => 'Crear Compañías'],
            ['name' => 'company_show', 'module_id' => 5, 'display_name' => 'Ver Compañías'],
            ['name' => 'company_edit', 'module_id' => 5, 'display_name' => 'Editar Compañías'],
            ['name' => 'company_destroy', 'module_id' => 5, 'display_name' => 'Eliminar Compañías'],

            ['name' => 'campus_index', 'module_id' => 6, 'display_name' => 'Listar Sedes'],
            ['name' => 'campus_create', 'module_id' => 6, 'display_name' => 'Crear Sedes'],
            ['name' => 'campus_show', 'module_id' => 6, 'display_name' => 'Ver Sedes'],
            ['name' => 'campus_edit', 'module_id' => 6, 'display_name' => 'Editar Sedes'],
            ['name' => 'campus_destroy', 'module_id' => 6, 'display_name' => 'Eliminar Sedes'],

            ['name' => 'area_index', 'module_id' => 7, 'display_name' => 'Listar Áreas'],
            ['name' => 'area_create', 'module_id' => 7, 'display_name' => 'Crear Áreas'],
            ['name' => 'area_show', 'module_id' => 7, 'display_name' => 'Ver Áreas'],
            ['name' => 'area_edit', 'module_id' => 7, 'display_name' => 'Editar Áreas'],
            ['name' => 'area_destroy', 'module_id' => 7, 'display_name' => 'Eliminar Áreas'],

            ['name' => 'position_index', 'module_id' => 8, 'display_name' => 'Listar Cargos'],
            ['name' => 'position_create', 'module_id' => 8, 'display_name' => 'Crear Cargos'],
            ['name' => 'position_show', 'module_id' => 8, 'display_name' => 'Ver Cargos'],
            ['name' => 'position_edit', 'module_id' => 8, 'display_name' => 'Editar Cargos'],
            ['name' => 'position_destroy', 'module_id' => 8, 'display_name' => 'Eliminar Cargos'],

            ['name' => 'collaborator_index', 'module_id' => 9, 'display_name' => 'Listar Colaboradores'],
            ['name' => 'collaborator_create', 'module_id' => 9, 'display_name' => 'Crear Colaboradores'],
            ['name' => 'collaborator_show', 'module_id' => 9, 'display_name' => 'Ver Colaboradores'],
            ['name' => 'collaborator_edit', 'module_id' => 9, 'display_name' => 'Editar Colaboradores'],
            ['name' => 'collaborator_destroy', 'module_id' => 9, 'display_name' => 'Eliminar Colaboradores'],
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
