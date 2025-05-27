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
            ['name' => 'home_master', 'module' => 'Home', 'display_name' => 'Home Master'],
            ['name' => 'home_super', 'module' => 'Home', 'display_name' => 'Home Super'],
            ['name' => 'home_admin', 'module' => 'Home', 'display_name' => 'Home Admin'],
            ['name' => 'home_generic', 'module' => 'Home', 'display_name' => 'Home Generic'],

            ['name' => 'permission_index', 'module' => 'Permisos', 'display_name' => 'Permisos'],
            ['name' => 'permission_create', 'module' => 'Permisos', 'display_name' => 'Crear Permisos'],
            ['name' => 'permission_show', 'module' => 'Permisos', 'display_name' => 'Mostrar Permisos'],
            ['name' => 'permission_edit', 'module' => 'Permisos', 'display_name' => 'Editar Permisos'],
            ['name' => 'permission_destroy', 'module' => 'Permisos', 'display_name' => 'Eliminar Permisos'],

            ['name' => 'role_index', 'module' => 'Roles', 'display_name' => 'Roles'],
            ['name' => 'role_create', 'module' => 'Roles', 'display_name' => 'Crear Roles'],
            ['name' => 'role_show', 'module' => 'Roles', 'display_name' => 'Mostrar Roles'],
            ['name' => 'role_edit', 'module' => 'Roles', 'display_name' => 'Editar Roles'],
            ['name' => 'role_destroy', 'module' => 'Roles', 'display_name' => 'Eliminar Roles'],

            ['name' => 'user_index', 'module' => 'Usuarios', 'display_name' => 'Listar Usuarios'],
            ['name' => 'user_create', 'module' => 'Usuarios', 'display_name' => 'Crear Usuarios'],
            ['name' => 'user_show', 'module' => 'Usuarios', 'display_name' => 'Ver Usuarios'],
            ['name' => 'user_edit', 'module' => 'Usuarios', 'display_name' => 'Editar Usuarios'],
            ['name' => 'user_destroy', 'module' => 'Usuarios', 'display_name' => 'Eliminar Usuarios'],

            ['name' => 'user_company_index', 'module' => 'Usuarios', 'display_name' => 'Listar Usuarios de Compañía'],
            ['name' => 'user_company_create', 'module' => 'Usuarios', 'display_name' => 'Crear Usuarios de Compañía'],
            ['name' => 'user_company_show', 'module' => 'Usuarios', 'display_name' => 'Ver Usuarios de Compañía'],
            ['name' => 'user_company_edit', 'module' => 'Usuarios', 'display_name' => 'Editar Usuarios de Compañía'],
            ['name' => 'user_company_destroy', 'module' => 'Usuarios', 'display_name' => 'Eliminar Usuarios de Compañía'],

            ['name' => 'company_index', 'module' => 'Compañias', 'display_name' => 'Listar Compañías'],
            ['name' => 'company_create', 'module' => 'Compañias', 'display_name' => 'Crear Compañías'],
            ['name' => 'company_show', 'module' => 'Compañias', 'display_name' => 'Ver Compañías'],
            ['name' => 'company_edit', 'module' => 'Compañias', 'display_name' => 'Editar Compañías'],
            ['name' => 'company_destroy', 'module' => 'Compañias', 'display_name' => 'Eliminar Compañías'],

            ['name' => 'campus_index', 'module' => 'Sedes', 'display_name' => 'Listar Sedes'],
            ['name' => 'campus_create', 'module' => 'Sedes', 'display_name' => 'Crear Sedes'],
            ['name' => 'campus_show', 'module' => 'Sedes', 'display_name' => 'Ver Sedes'],
            ['name' => 'campus_edit', 'module' => 'Sedes', 'display_name' => 'Editar Sedes'],
            ['name' => 'campus_destroy', 'module' => 'Sedes', 'display_name' => 'Eliminar Sedes'],

            ['name' => 'area_index', 'module' => 'Areas', 'display_name' => 'Listar Áreas'],
            ['name' => 'area_create', 'module' => 'Areas', 'display_name' => 'Crear Áreas'],
            ['name' => 'area_show', 'module' => 'Areas', 'display_name' => 'Ver Áreas'],
            ['name' => 'area_edit', 'module' => 'Areas', 'display_name' => 'Editar Áreas'],
            ['name' => 'area_destroy', 'module' => 'Areas', 'display_name' => 'Eliminar Áreas'],

            ['name' => 'position_index', 'module' => 'Cargos', 'display_name' => 'Listar Cargos'],
            ['name' => 'position_create', 'module' => 'Cargos', 'display_name' => 'Crear Cargos'],
            ['name' => 'position_show', 'module' => 'Cargos', 'display_name' => 'Ver Cargos'],
            ['name' => 'position_edit', 'module' => 'Cargos', 'display_name' => 'Editar Cargos'],
            ['name' => 'position_destroy', 'module' => 'Cargos', 'display_name' => 'Eliminar Cargos'],

            ['name' => 'collaborator_index', 'module' => 'Colaboradores', 'display_name' => 'Listar Colaboradores'],
            ['name' => 'collaborator_create', 'module' => 'Colaboradores', 'display_name' => 'Crear Colaboradores'],
            ['name' => 'collaborator_show', 'module' => 'Colaboradores', 'display_name' => 'Ver Colaboradores'],
            ['name' => 'collaborator_edit', 'module' => 'Colaboradores', 'display_name' => 'Editar Colaboradores'],
            ['name' => 'collaborator_destroy', 'module' => 'Colaboradores', 'display_name' => 'Eliminar Colaboradores'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'company_id' => 1,
                'module' => $permission['module'],
                'display_name' => $permission['display_name'],
                'guard_name' => 'web',
            ]);
        }
    }
}
