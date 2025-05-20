<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollaboratorRequisitionTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('collaborator_requisition_types')->insert([
            ['name' => 'Interna'],
            ['name' => 'Externa'],
            ['name' => 'Mixta']
        ]);
    }
}
