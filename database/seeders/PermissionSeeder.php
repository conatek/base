<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'home_master',
            'home_super',
            'home_admin',
            'home_generic',

            'permission_index',
            'permission_create',
            'permission_show',
            'permission_edit',
            'permission_destroy',

            'role_index',
            'role_create',
            'role_show',
            'role_edit',
            'role_destroy',

            'user_index',
            'user_create',
            'user_show',
            'user_edit',
            'user_destroy',

            'user_company_index',
            'user_company_create',
            'user_company_show',
            'user_company_edit',
            'user_company_destroy',

            'company_index',
            'company_create',
            'company_show',
            'company_edit',
            'company_destroy',

            'area_index',
            'area_create',
            'area_show',
            'area_edit',
            'area_destroy',

            'position_index',
            'position_create',
            'position_show',
            'position_edit',
            'position_destroy',

            'campus_index',
            'campus_create',
            'campus_show',
            'campus_edit',
            'campus_destroy',

            'collaborator_index',
            'collaborator_create',
            'collaborator_show',
            'collaborator_edit',
            'collaborator_destroy',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
               'name' => $permission,
            ]);
        }
    }
}
