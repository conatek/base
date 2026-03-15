<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'company_id'     => 1,
            'name'           => 'Antonio',
            'first_surname'  => 'Contreras',
            'email'          => 'conatekpro@gmail.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user->assignRole('Master');

        $user_master = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Master',
            'email'          => 'master@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_master->assignRole('Master');

        $user_super = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Super',
            'email'          => 'super@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_super->assignRole('Super');

        $user_admin = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Admin',
            'email'          => 'admin@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_admin->assignRole('Admin');

        $user_analyst = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Analyst',
            'email'          => 'analyst@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_analyst->assignRole('Analyst');

        $user_collaborator = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Collaborator',
            'email'          => 'collaborator@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_collaborator->assignRole('Collaborator');

        $user_requester = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Requester',
            'email'          => 'requester@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_requester->assignRole('Requester');

        $user_approver = User::create([
            'company_id'     => 1,
            'name'           => 'Test',
            'first_surname'  => 'Approver',
            'email'          => 'approver@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_approver->assignRole('Approver');

        $user_mh_admin = User::create([
            'company_id'     => 2,
            'name'           => 'MH',
            'first_surname'  => 'Admin',
            'email'          => 'mh_admin@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_mh_admin->assignRole('Admin');

        $user_mh_collaborator = User::create([
            'company_id'     => 2,
            'name'           => 'MH',
            'first_surname'  => 'Collaborator',
            'email'          => 'mh_collaborator@test.com',
            'password'       => bcrypt('29405014'),
        ]);
        $user_mh_collaborator->assignRole('Collaborator');
    }
}
