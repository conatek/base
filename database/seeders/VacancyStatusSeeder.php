<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VacancyStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Abierta',
            'En proceso',
            'Cerrada',
            'Cancelada',
            'En espera de aprobación',
        ];

        foreach ($statuses as $status) {
            DB::table('vacancy_statuses')->updateOrInsert(['name' => $status]);
        }
    }
}
