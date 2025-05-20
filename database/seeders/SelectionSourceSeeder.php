<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SelectionSourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            'Convocatoria interna',
            'Recomendación de empleado',
            'Portal de empleo - Computrabajo',
            'Portal de empleo - Elempleo',
            'Portal de empleo - Indeed',
            'Portal de empleo - Magneto 365',
            'Portal de empleo - Universia',
            'Portal de empleo - Servicio público de Empleo (SPE)',
            'Portal de empleo - TicJob',
            'Portal de empleo - Otros',
            'Redes sociales - LinkedIn',
            'Redes sociales - Facebook',
            'Redes sociales - Twitter',
            'Redes sociales - Instagram',
            'Redes sociales - TikTok',
            'Redes sociales - WhatsApp',
            'Redes sociales - Otras',
            'Agencia de empleo',
            'Feria laboral',
            'Base de datos interna',
            'Referido por cliente/proveedor',
        ];

        foreach ($sources as $source) {
            DB::table('selection_sources')->updateOrInsert(['name' => $source]);
        }
    }
}
