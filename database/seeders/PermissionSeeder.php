<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();

        $permissions = [
            // ─── Módulo 1: Home ─────────────────────────────────────────────────────
            ['name' => 'block_company',         'module_id' => 1,  'display_name' => 'Bloque de Gestión de Empresa'],
            ['name' => 'block_collaborators',   'module_id' => 1,  'display_name' => 'Bloque de Gestión de Colaboradores'],
            ['name' => 'block_self_management', 'module_id' => 1,  'display_name' => 'Bloque de Autogestión'],
            ['name' => 'block_utilities',       'module_id' => 1,  'display_name' => 'Bloque de Utilidades'],
            ['name' => 'home_index',            'module_id' => 1,  'display_name' => 'Home'],

            // ─── Módulo 2: Empresas ─────────────────────────────────────────────────
            ['name' => 'companies_index',   'module_id' => 2,  'display_name' => 'Listar Empresas'],
            ['name' => 'companies_create',  'module_id' => 2,  'display_name' => 'Crear Empresas'],
            ['name' => 'companies_show',    'module_id' => 2,  'display_name' => 'Ver Empresas'],
            ['name' => 'companies_edit',    'module_id' => 2,  'display_name' => 'Editar Empresas'],
            ['name' => 'companies_destroy', 'module_id' => 2,  'display_name' => 'Eliminar Empresas'],

            // ─── Módulo 3: Roles ────────────────────────────────────────────────────
            ['name' => 'roles_index',   'module_id' => 3,  'display_name' => 'Listar Roles'],
            ['name' => 'roles_create',  'module_id' => 3,  'display_name' => 'Crear Roles'],
            ['name' => 'roles_show',    'module_id' => 3,  'display_name' => 'Ver Roles'],
            ['name' => 'roles_edit',    'module_id' => 3,  'display_name' => 'Editar Roles'],
            ['name' => 'roles_destroy', 'module_id' => 3,  'display_name' => 'Eliminar Roles'],

            // ─── Módulo 4: Permisos ─────────────────────────────────────────────────
            ['name' => 'permissions_index',   'module_id' => 4,  'display_name' => 'Listar Permisos'],
            ['name' => 'permissions_create',  'module_id' => 4,  'display_name' => 'Crear Permisos'],
            ['name' => 'permissions_show',    'module_id' => 4,  'display_name' => 'Ver Permisos'],
            ['name' => 'permissions_edit',    'module_id' => 4,  'display_name' => 'Editar Permisos'],
            ['name' => 'permissions_destroy', 'module_id' => 4,  'display_name' => 'Eliminar Permisos'],

            // ─── Módulo 5: Usuarios ─────────────────────────────────────────────────
            ['name' => 'users_index',   'module_id' => 5,  'display_name' => 'Listar Usuarios'],
            ['name' => 'users_create',  'module_id' => 5,  'display_name' => 'Crear Usuarios'],
            ['name' => 'users_show',    'module_id' => 5,  'display_name' => 'Ver Usuarios'],
            ['name' => 'users_edit',    'module_id' => 5,  'display_name' => 'Editar Usuarios'],
            ['name' => 'users_destroy', 'module_id' => 5,  'display_name' => 'Eliminar Usuarios'],

            // ─── Módulo 6: Organización ─────────────────────────────────────────────
            ['name' => 'company_index', 'module_id' => 6,  'display_name' => 'Organización'],

            // ─── Módulo 7: Sedes ────────────────────────────────────────────────────
            ['name' => 'campus_index',   'module_id' => 7,  'display_name' => 'Listar Sedes'],
            ['name' => 'campus_create',  'module_id' => 7,  'display_name' => 'Crear Sedes'],
            ['name' => 'campus_show',    'module_id' => 7,  'display_name' => 'Ver Sedes'],
            ['name' => 'campus_edit',    'module_id' => 7,  'display_name' => 'Editar Sedes'],
            ['name' => 'campus_destroy', 'module_id' => 7,  'display_name' => 'Eliminar Sedes'],

            // ─── Módulo 8: Áreas ────────────────────────────────────────────────────
            ['name' => 'areas_index',   'module_id' => 8,  'display_name' => 'Listar Áreas'],
            ['name' => 'areas_create',  'module_id' => 8,  'display_name' => 'Crear Áreas'],
            ['name' => 'areas_show',    'module_id' => 8,  'display_name' => 'Ver Áreas'],
            ['name' => 'areas_edit',    'module_id' => 8,  'display_name' => 'Editar Áreas'],
            ['name' => 'areas_destroy', 'module_id' => 8,  'display_name' => 'Eliminar Áreas'],

            // ─── Módulo 9: Cargos ───────────────────────────────────────────────────
            ['name' => 'positions_index',   'module_id' => 9,  'display_name' => 'Listar Cargos'],
            ['name' => 'positions_create',  'module_id' => 9,  'display_name' => 'Crear Cargos'],
            ['name' => 'positions_show',    'module_id' => 9,  'display_name' => 'Ver Cargos'],
            ['name' => 'positions_edit',    'module_id' => 9,  'display_name' => 'Editar Cargos'],
            ['name' => 'positions_destroy', 'module_id' => 9,  'display_name' => 'Eliminar Cargos'],

            // ─── Módulo 10: Colaboradores ───────────────────────────────────────────
            ['name' => 'collaborators_index',   'module_id' => 10, 'display_name' => 'Listar Colaboradores'],
            ['name' => 'collaborators_create',  'module_id' => 10, 'display_name' => 'Crear Colaboradores'],
            ['name' => 'collaborators_show',    'module_id' => 10, 'display_name' => 'Ver Colaboradores'],
            ['name' => 'collaborators_edit',    'module_id' => 10, 'display_name' => 'Editar Colaboradores'],
            ['name' => 'collaborators_destroy', 'module_id' => 10, 'display_name' => 'Eliminar Colaboradores'],

            // ─── Módulo 11: Procesos de Selección ──────────────────────────────────
            ['name' => 'selection_index',      'module_id' => 11, 'display_name' => 'Acceso a Selección'],
            ['name' => 'requisition_create',   'module_id' => 11, 'display_name' => 'Crear Requisiciones'],
            ['name' => 'requisition_show',     'module_id' => 11, 'display_name' => 'Ver Requisiciones'],
            ['name' => 'requisition_edit',     'module_id' => 11, 'display_name' => 'Editar Requisiciones'],
            ['name' => 'requisition_approve',  'module_id' => 11, 'display_name' => 'Aprobar Requisiciones'],
            ['name' => 'requisition_cancel',   'module_id' => 11, 'display_name' => 'Cancelar Requisiciones'],

            // ─── Módulo 12: Ausentismo ──────────────────────────────────────────────
            ['name' => 'absence_index',   'module_id' => 12, 'display_name' => 'Listar Ausentismos'],
            ['name' => 'absence_create',  'module_id' => 12, 'display_name' => 'Crear Ausentismos'],
            ['name' => 'absence_show',    'module_id' => 12, 'display_name' => 'Ver Ausentismos'],
            ['name' => 'absence_edit',    'module_id' => 12, 'display_name' => 'Editar Ausentismos'],
            ['name' => 'absence_destroy', 'module_id' => 12, 'display_name' => 'Eliminar Ausentismos'],

            // ─── Módulo 13: Dotación ────────────────────────────────────────────────
            ['name' => 'provision_index',   'module_id' => 13, 'display_name' => 'Listar Dotaciones'],
            ['name' => 'provision_create',  'module_id' => 13, 'display_name' => 'Crear Dotaciones'],
            ['name' => 'provision_show',    'module_id' => 13, 'display_name' => 'Ver Dotaciones'],
            ['name' => 'provision_edit',    'module_id' => 13, 'display_name' => 'Editar Dotaciones'],
            ['name' => 'provision_destroy', 'module_id' => 13, 'display_name' => 'Eliminar Dotaciones'],

            // ─── Módulo 14: Planes de Formación ────────────────────────────────────
            ['name' => 'training_index',   'module_id' => 14, 'display_name' => 'Listar Planes de Formación'],
            ['name' => 'training_create',  'module_id' => 14, 'display_name' => 'Crear Planes de Formación'],
            ['name' => 'training_show',    'module_id' => 14, 'display_name' => 'Ver Planes de Formación'],
            ['name' => 'training_edit',    'module_id' => 14, 'display_name' => 'Editar Planes de Formación'],
            ['name' => 'training_destroy', 'module_id' => 14, 'display_name' => 'Eliminar Planes de Formación'],

            // ─── Módulo 15: Evaluación de Desempeño ────────────────────────────────
            ['name' => 'performance_index',   'module_id' => 15, 'display_name' => 'Listar Evaluaciones de Desempeño'],
            ['name' => 'performance_create',  'module_id' => 15, 'display_name' => 'Crear Evaluaciones de Desempeño'],
            ['name' => 'performance_show',    'module_id' => 15, 'display_name' => 'Ver Evaluaciones de Desempeño'],
            ['name' => 'performance_edit',    'module_id' => 15, 'display_name' => 'Editar Evaluaciones de Desempeño'],
            ['name' => 'performance_destroy', 'module_id' => 15, 'display_name' => 'Eliminar Evaluaciones de Desempeño'],

            // ─── Módulo 16: Bienestar ───────────────────────────────────────────────
            ['name' => 'wellness_index',   'module_id' => 16, 'display_name' => 'Listar Bienestar'],
            ['name' => 'wellness_create',  'module_id' => 16, 'display_name' => 'Crear Bienestar'],
            ['name' => 'wellness_show',    'module_id' => 16, 'display_name' => 'Ver Bienestar'],
            ['name' => 'wellness_edit',    'module_id' => 16, 'display_name' => 'Editar Bienestar'],
            ['name' => 'wellness_destroy', 'module_id' => 16, 'display_name' => 'Eliminar Bienestar'],

            // ─── Módulo 17: Autogestión ─────────────────────────────────────────────
            ['name' => 'self_management_index',   'module_id' => 17, 'display_name' => 'Autogestión'],
            ['name' => 'self_management_profile', 'module_id' => 17, 'display_name' => 'Mi Perfil'],

            // ─── Módulo 18: Herramientas ────────────────────────────────────────────
            ['name' => 'tools_index',   'module_id' => 18, 'display_name' => 'Listar Herramientas'],
            ['name' => 'tools_create',  'module_id' => 18, 'display_name' => 'Crear Herramientas'],
            ['name' => 'tools_show',    'module_id' => 18, 'display_name' => 'Ver Herramientas'],
            ['name' => 'tools_edit',    'module_id' => 18, 'display_name' => 'Editar Herramientas'],
            ['name' => 'tools_destroy', 'module_id' => 18, 'display_name' => 'Eliminar Herramientas'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name'         => $permission['name'],
                'module_id'    => $permission['module_id'],
                'display_name' => $permission['display_name'],
                'guard_name'   => 'web',
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
