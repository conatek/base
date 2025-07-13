<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ============================
        // Asignación de permisos por rol: MASTER
        // ============================
        $master_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($master_permissions->pluck('id'));

        // ============================
        // Asignación de permisos por rol: SUPER
        // ============================
        $superRole = Role::findOrFail(2);

        $excludedSuperPermissions = [
            'roles_index',
            'roles_create',
            'roles_show',
            'roles_edit',
            'roles_destroy',
            'permissions_index',
            'permissions_create',
            'permissions_show',
            'permissions_edit',
            'permissions_destroy',
        ];

        $superPermissions = Permission::all()->filter(function ($permission) use ($excludedSuperPermissions) {
            if (in_array($permission->name, $excludedSuperPermissions)) {
                return false;
            }

            return true;
        });

        $superRole->permissions()->sync($superPermissions->pluck('id'));

        // ============================
        // Asignación de permisos por rol: ADMIN
        // ============================
        $adminRole = Role::findOrFail(3);

        $excludedAdminPermissions = [
            'companies_index',
            'companies_create',
            'companies_show',
            'companies_edit',
            'companies_destroy',
            'roles_index',
            'roles_create',
            'roles_show',
            'roles_edit',
            'roles_destroy',
            'permissions_index',
            'permissions_create',
            'permissions_show',
            'permissions_edit',
            'permissions_destroy',
        ];

        $adminPermissions = Permission::all()->filter(function ($permission) use ($excludedAdminPermissions) {
            if (in_array($permission->name, $excludedAdminPermissions)) {
                return false;
            }

            return true;
        });

        $adminRole->permissions()->sync($adminPermissions->pluck('id'));

        // ============================
        // Asignación de permisos por rol: ANALYST
        // ============================
        $analystRole = Role::findOrFail(4);

        $excludedAnalystPermissions = [
            'companies_index',
            'companies_create',
            'companies_show',
            'companies_edit',
            'companies_destroy',
            'roles_index',
            'roles_create',
            'roles_show',
            'roles_edit',
            'roles_destroy',
            'permissions_index',
            'permissions_create',
            'permissions_show',
            'permissions_edit',
            'permissions_destroy',
            'users_index',
            'users_create',
            'users_show',
            'users_edit',
            'users_destroy',
            'company_index',
            'campus_index',
            'campus_create',
            'campus_show',
            'campus_edit',
            'campus_destroy',
            'areas_index',
            'areas_create',
            'areas_show',
            'areas_edit',
            'areas_destroy',
            'positions_index',
            'positions_create',
            'positions_show',
            'positions_edit',
            'positions_destroy',
        ];

        $analystPermissions = Permission::all()->filter(function ($permission) use ($excludedAnalystPermissions) {
            if (in_array($permission->name, $excludedAnalystPermissions)) {
                return false;
            }

            return true;
        });

        $analystRole->permissions()->sync($analystPermissions->pluck('id'));

        // ============================
        // Asignación de permisos por rol: COLLABORATOR
        // ============================
        $collaboratorRole = Role::findOrFail(5);

        $excludedCollaboratorPermissions = [
            'block_collaborators',
            'block_utilities',
            'companies_index',
            'companies_create',
            'companies_show',
            'companies_edit',
            'companies_destroy',
            'roles_index',
            'roles_create',
            'roles_show',
            'roles_edit',
            'roles_destroy',
            'permissions_index',
            'permissions_create',
            'permissions_show',
            'permissions_edit',
            'permissions_destroy',
            'users_index',
            'users_create',
            'users_show',
            'users_edit',
            'users_destroy',
            'company_index',
            'campus_index',
            'campus_create',
            'campus_show',
            'campus_edit',
            'campus_destroy',
            'areas_index',
            'areas_create',
            'areas_show',
            'areas_edit',
            'areas_destroy',
            'positions_index',
            'positions_create',
            'positions_show',
            'positions_edit',
            'positions_destroy',
            'collaborators_index',
            'collaborators_create',
            'collaborators_show',
            'collaborators_edit',
            'collaborators_destroy',
        ];

        $collaboratorPermissions = Permission::all()->filter(function ($permission) use ($excludedCollaboratorPermissions) {
            if (in_array($permission->name, $excludedCollaboratorPermissions)) {
                return false;
            }

            return true;
        });

        $collaboratorRole->permissions()->sync($collaboratorPermissions->pluck('id'));

        // ============================
        // Asignación de permisos por rol: REQUESTER
        // ============================
        $requesterRole = Role::findOrFail(6);

        $excludedRequesterPermissions = [
            'block_collaborators',
            'block_utilities',
            'companies_index',
            'companies_create',
            'companies_show',
            'companies_edit',
            'companies_destroy',
            'roles_index',
            'roles_create',
            'roles_show',
            'roles_edit',
            'roles_destroy',
            'permissions_index',
            'permissions_create',
            'permissions_show',
            'permissions_edit',
            'permissions_destroy',
            'users_index',
            'users_create',
            'users_show',
            'users_edit',
            'users_destroy',
            'company_index',
            'campus_index',
            'campus_create',
            'campus_show',
            'campus_edit',
            'campus_destroy',
            'areas_index',
            'areas_create',
            'areas_show',
            'areas_edit',
            'areas_destroy',
            'positions_index',
            'positions_create',
            'positions_show',
            'positions_edit',
            'positions_destroy',
            'collaborators_index',
            'collaborators_create',
            'collaborators_show',
            'collaborators_edit',
            'collaborators_destroy',
        ];

        $requesterPermissions = Permission::all()->filter(function ($permission) use ($excludedRequesterPermissions) {
            if (in_array($permission->name, $excludedRequesterPermissions)) {
                return false;
            }

            return true;
        });

        $requesterRole->permissions()->sync($requesterPermissions->pluck('id'));

        // ============================
        // Asignación de permisos por rol: APPROVER
        // ============================
        $approverRole = Role::findOrFail(7);

        $excludedApproverPermissions = [
            'block_collaborators',
            'block_utilities',
            'companies_index',
            'companies_create',
            'companies_show',
            'companies_edit',
            'companies_destroy',
            'roles_index',
            'roles_create',
            'roles_show',
            'roles_edit',
            'roles_destroy',
            'permissions_index',
            'permissions_create',
            'permissions_show',
            'permissions_edit',
            'permissions_destroy',
            'users_index',
            'users_create',
            'users_show',
            'users_edit',
            'users_destroy',
            'company_index',
            'campus_index',
            'campus_create',
            'campus_show',
            'campus_edit',
            'campus_destroy',
            'areas_index',
            'areas_create',
            'areas_show',
            'areas_edit',
            'areas_destroy',
            'positions_index',
            'positions_create',
            'positions_show',
            'positions_edit',
            'positions_destroy',
            'collaborators_index',
            'collaborators_create',
            'collaborators_show',
            'collaborators_edit',
            'collaborators_destroy',
        ];

        $approverPermissions = Permission::all()->filter(function ($permission) use ($excludedApproverPermissions) {
            if (in_array($permission->name, $excludedApproverPermissions)) {
                return false;
            }

            return true;
        });

        $approverRole->permissions()->sync($approverPermissions->pluck('id'));
    }
}

