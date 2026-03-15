<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    public function run()
    {
        // ============================
        // MASTER — todos los permisos
        // ============================
        Role::findOrFail(1)->permissions()->sync(Permission::all()->pluck('id'));

        // ============================
        // SUPER — todo excepto gestión de roles y permisos
        // ============================
        $superRole = Role::findOrFail(2);
        $superExcluded = [
            'roles_index', 'roles_create', 'roles_show', 'roles_edit', 'roles_destroy',
            'permissions_index', 'permissions_create', 'permissions_show', 'permissions_edit', 'permissions_destroy',
        ];
        $superRole->permissions()->sync(
            Permission::all()->whereNotIn('name', $superExcluded)->pluck('id')
        );

        // ============================
        // ADMIN — gestión de empresa y colaboradores; acceso completo a selección y ausentismo
        // ============================
        $adminRole = Role::findOrFail(3);
        $adminExcluded = [
            'block_utilities',
            'companies_index', 'companies_create', 'companies_show', 'companies_edit', 'companies_destroy',
            'roles_index', 'roles_create', 'roles_show', 'roles_edit', 'roles_destroy',
            'permissions_index', 'permissions_create', 'permissions_show', 'permissions_edit', 'permissions_destroy',
            // Módulos no implementados aún
            'provision_index', 'provision_create', 'provision_show', 'provision_edit', 'provision_destroy',
            'training_index', 'training_create', 'training_show', 'training_edit', 'training_destroy',
            'performance_index', 'performance_create', 'performance_show', 'performance_edit', 'performance_destroy',
            'wellness_index', 'wellness_create', 'wellness_show', 'wellness_edit', 'wellness_destroy',
            'tools_index', 'tools_create', 'tools_show', 'tools_edit', 'tools_destroy',
        ];
        $adminRole->permissions()->sync(
            Permission::all()->whereNotIn('name', $adminExcluded)->pluck('id')
        );

        // ============================
        // ANALYST — consulta y gestión operativa; sin acceso a administración de empresa/usuarios
        // ============================
        $analystRole = Role::findOrFail(4);
        $analystExcluded = [
            'block_utilities',
            'companies_index', 'companies_create', 'companies_show', 'companies_edit', 'companies_destroy',
            'roles_index', 'roles_create', 'roles_show', 'roles_edit', 'roles_destroy',
            'permissions_index', 'permissions_create', 'permissions_show', 'permissions_edit', 'permissions_destroy',
            'users_index', 'users_create', 'users_show', 'users_edit', 'users_destroy',
            'company_index',
            'campus_index', 'campus_create', 'campus_show', 'campus_edit', 'campus_destroy',
            'areas_index', 'areas_create', 'areas_show', 'areas_edit', 'areas_destroy',
            'positions_index', 'positions_create', 'positions_show', 'positions_edit', 'positions_destroy',
            // Módulos no implementados aún
            'provision_index', 'provision_create', 'provision_show', 'provision_edit', 'provision_destroy',
            'training_index', 'training_create', 'training_show', 'training_edit', 'training_destroy',
            'performance_index', 'performance_create', 'performance_show', 'performance_edit', 'performance_destroy',
            'wellness_index', 'wellness_create', 'wellness_show', 'wellness_edit', 'wellness_destroy',
            'tools_index', 'tools_create', 'tools_show', 'tools_edit', 'tools_destroy',
        ];
        $analystRole->permissions()->sync(
            Permission::all()->whereNotIn('name', $analystExcluded)->pluck('id')
        );

        // ============================
        // COLLABORATOR — solo autogestión; sin acceso a selección ni administración
        // ============================
        $collaboratorRole = Role::findOrFail(5);
        $collaboratorExcluded = [
            'block_collaborators', 'block_utilities',
            'companies_index', 'companies_create', 'companies_show', 'companies_edit', 'companies_destroy',
            'roles_index', 'roles_create', 'roles_show', 'roles_edit', 'roles_destroy',
            'permissions_index', 'permissions_create', 'permissions_show', 'permissions_edit', 'permissions_destroy',
            'users_index', 'users_create', 'users_show', 'users_edit', 'users_destroy',
            'company_index',
            'campus_index', 'campus_create', 'campus_show', 'campus_edit', 'campus_destroy',
            'areas_index', 'areas_create', 'areas_show', 'areas_edit', 'areas_destroy',
            'positions_index', 'positions_create', 'positions_show', 'positions_edit', 'positions_destroy',
            'collaborators_index', 'collaborators_create', 'collaborators_show', 'collaborators_edit', 'collaborators_destroy',
            'selection_index', 'requisition_create', 'requisition_show', 'requisition_edit', 'requisition_approve', 'requisition_cancel',
            'absence_index', 'absence_create', 'absence_show', 'absence_edit', 'absence_destroy',
            'provision_index', 'provision_create', 'provision_show', 'provision_edit', 'provision_destroy',
            'training_index', 'training_create', 'training_show', 'training_edit', 'training_destroy',
            'performance_index', 'performance_create', 'performance_show', 'performance_edit', 'performance_destroy',
            'wellness_index', 'wellness_create', 'wellness_show', 'wellness_edit', 'wellness_destroy',
            'tools_index', 'tools_create', 'tools_show', 'tools_edit', 'tools_destroy',
        ];
        $collaboratorRole->permissions()->sync(
            Permission::all()->whereNotIn('name', $collaboratorExcluded)->pluck('id')
        );

        // ============================
        // REQUESTER — puede crear, ver y editar sus propias requisiciones; no puede aprobar ni cancelar
        // ============================
        $requesterRole = Role::findOrFail(6);
        $requesterExcluded = [
            'block_collaborators', 'block_utilities',
            'companies_index', 'companies_create', 'companies_show', 'companies_edit', 'companies_destroy',
            'roles_index', 'roles_create', 'roles_show', 'roles_edit', 'roles_destroy',
            'permissions_index', 'permissions_create', 'permissions_show', 'permissions_edit', 'permissions_destroy',
            'users_index', 'users_create', 'users_show', 'users_edit', 'users_destroy',
            'company_index',
            'campus_index', 'campus_create', 'campus_show', 'campus_edit', 'campus_destroy',
            'areas_index', 'areas_create', 'areas_show', 'areas_edit', 'areas_destroy',
            'positions_index', 'positions_create', 'positions_show', 'positions_edit', 'positions_destroy',
            'collaborators_index', 'collaborators_create', 'collaborators_show', 'collaborators_edit', 'collaborators_destroy',
            // Puede crear/ver/editar; no puede aprobar ni cancelar
            'requisition_approve', 'requisition_cancel',
            'absence_index', 'absence_create', 'absence_show', 'absence_edit', 'absence_destroy',
            'provision_index', 'provision_create', 'provision_show', 'provision_edit', 'provision_destroy',
            'training_index', 'training_create', 'training_show', 'training_edit', 'training_destroy',
            'performance_index', 'performance_create', 'performance_show', 'performance_edit', 'performance_destroy',
            'wellness_index', 'wellness_create', 'wellness_show', 'wellness_edit', 'wellness_destroy',
            'tools_index', 'tools_create', 'tools_show', 'tools_edit', 'tools_destroy',
        ];
        $requesterRole->permissions()->sync(
            Permission::all()->whereNotIn('name', $requesterExcluded)->pluck('id')
        );

        // ============================
        // APPROVER — puede ver, aprobar y cancelar requisiciones; no puede crearlas ni editarlas
        // ============================
        $approverRole = Role::findOrFail(7);
        $approverExcluded = [
            'block_collaborators', 'block_utilities',
            'companies_index', 'companies_create', 'companies_show', 'companies_edit', 'companies_destroy',
            'roles_index', 'roles_create', 'roles_show', 'roles_edit', 'roles_destroy',
            'permissions_index', 'permissions_create', 'permissions_show', 'permissions_edit', 'permissions_destroy',
            'users_index', 'users_create', 'users_show', 'users_edit', 'users_destroy',
            'company_index',
            'campus_index', 'campus_create', 'campus_show', 'campus_edit', 'campus_destroy',
            'areas_index', 'areas_create', 'areas_show', 'areas_edit', 'areas_destroy',
            'positions_index', 'positions_create', 'positions_show', 'positions_edit', 'positions_destroy',
            'collaborators_index', 'collaborators_create', 'collaborators_show', 'collaborators_edit', 'collaborators_destroy',
            // Puede ver/aprobar/cancelar; no puede crear ni editar
            'requisition_create', 'requisition_edit',
            'absence_index', 'absence_create', 'absence_show', 'absence_edit', 'absence_destroy',
            'provision_index', 'provision_create', 'provision_show', 'provision_edit', 'provision_destroy',
            'training_index', 'training_create', 'training_show', 'training_edit', 'training_destroy',
            'performance_index', 'performance_create', 'performance_show', 'performance_edit', 'performance_destroy',
            'wellness_index', 'wellness_create', 'wellness_show', 'wellness_edit', 'wellness_destroy',
            'tools_index', 'tools_create', 'tools_show', 'tools_edit', 'tools_destroy',
        ];
        $approverRole->permissions()->sync(
            Permission::all()->whereNotIn('name', $approverExcluded)->pluck('id')
        );
    }
}
