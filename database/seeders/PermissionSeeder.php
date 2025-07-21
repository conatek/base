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

            ['name' => 'selection_index', 'module_id' => 11, 'display_name' => 'Listar Procesos de Selección'],
            ['name' => 'selection_create', 'module_id' => 11, 'display_name' => 'Crear Procesos de Selección'],
            ['name' => 'selection_show', 'module_id' => 11, 'display_name' => 'Ver Procesos de Selección'],
            ['name' => 'selection_edit', 'module_id' => 11, 'display_name' => 'Editar Procesos de Selección'],
            ['name' => 'selection_destroy', 'module_id' => 11, 'display_name' => 'Eliminar Procesos de Selección'],

            ['name' => 'absence_index', 'module_id' => 12, 'display_name' => 'Listar Ausentismos'],
            ['name' => 'absence_create', 'module_id' => 12, 'display_name' => 'Crear Ausentismos'],
            ['name' => 'absence_show', 'module_id' => 12, 'display_name' => 'Ver Ausentismos'],
            ['name' => 'absence_edit', 'module_id' => 12, 'display_name' => 'Editar Ausentismos'],
            ['name' => 'absence_destroy', 'module_id' => 12, 'display_name' => 'Eliminar Ausentismos'],

            ['name' => 'provision_index', 'module_id' => 13, 'display_name' => 'Listar Dotaciones'],
            ['name' => 'provision_create', 'module_id' => 13, 'display_name' => 'Crear Dotaciones'],
            ['name' => 'provision_show', 'module_id' => 13, 'display_name' => 'Ver Dotaciones'],
            ['name' => 'provision_edit', 'module_id' => 13, 'display_name' => 'Editar Dotaciones'],
            ['name' => 'provision_destroy', 'module_id' => 13, 'display_name' => 'Eliminar Dotaciones'],

            ['name' => 'training_index', 'module_id' => 14, 'display_name' => 'Listar Planes de Formación'],
            ['name' => 'training_create', 'module_id' => 14, 'display_name' => 'Crear Planes de Formación'],
            ['name' => 'training_show', 'module_id' => 14, 'display_name' => 'Ver Planes de Formación'],
            ['name' => 'training_edit', 'module_id' => 14, 'display_name' => 'Editar Planes de Formación'],
            ['name' => 'training_destroy', 'module_id' => 14, 'display_name' => 'Eliminar Planes de Formación'],

            ['name' => 'performance_index', 'module_id' => 15, 'display_name' => 'Listar Evaluaciones de Desempeño'],
            ['name' => 'performance_create', 'module_id' => 15, 'display_name' => 'Crear Evaluaciones de Desempeño'],
            ['name' => 'performance_show', 'module_id' => 15, 'display_name' => 'Ver Evaluaciones de Desempeño'],
            ['name' => 'performance_edit', 'module_id' => 15, 'display_name' => 'Editar Evaluaciones de Desempeño'],
            ['name' => 'performance_destroy', 'module_id' => 15, 'display_name' => 'Eliminar Evaluaciones de Desempeño'],

            ['name' => 'wellness_index', 'module_id' => 16, 'display_name' => 'Listar Bienestar'],
            ['name' => 'wellness_create', 'module_id' => 16, 'display_name' => 'Crear Bienestar'],
            ['name' => 'wellness_show', 'module_id' => 16, 'display_name' => 'Ver Bienestar'],
            ['name' => 'wellness_edit', 'module_id' => 16, 'display_name' => 'Editar Bienestar'],
            ['name' => 'wellness_destroy', 'module_id' => 16, 'display_name' => 'Eliminar Bienestar'],

            ['name' => 'self_management_index', 'module_id' => 17, 'display_name' => 'Listar Autogestión'],
            ['name' => 'self_management_create', 'module_id' => 17, 'display_name' => 'Crear Autogestión'],
            ['name' => 'self_management_show', 'module_id' => 17, 'display_name' => 'Ver Autogestión'],
            ['name' => 'self_management_edit', 'module_id' => 17, 'display_name' => 'Editar Autogestión'],
            ['name' => 'self_management_destroy', 'module_id' => 17, 'display_name' => 'Eliminar Autogestión'],

            ['name' => 'cms_index', 'module_id' => 18, 'display_name' => 'Listar CMS'],
            ['name' => 'cms_create', 'module_id' => 18, 'display_name' => 'Crear CMS'],
            ['name' => 'cms_show', 'module_id' => 18, 'display_name' => 'Ver CMS'],
            ['name' => 'cms_edit', 'module_id' => 18, 'display_name' => 'Editar CMS'],
            ['name' => 'cms_destroy', 'module_id' => 18, 'display_name' => 'Eliminar CMS'],

            ['name' => 'tools_index', 'module_id' => 19, 'display_name' => 'Listar Herramientas'],
            ['name' => 'tools_create', 'module_id' => 19, 'display_name' => 'Crear Herramientas'],
            ['name' => 'tools_show', 'module_id' => 19, 'display_name' => 'Ver Herramientas'],
            ['name' => 'tools_edit', 'module_id' => 19, 'display_name' => 'Editar Herramientas'],
            ['name' => 'tools_destroy', 'module_id' => 19, 'display_name' => 'Eliminar Herramientas'],


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
