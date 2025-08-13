<?php

namespace Database\Seeders;

use App\Models\ProviderType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProviderType::create(['type' => 'Directo (Empresa Propia)']);
        ProviderType::create(['type' => 'EST (Empresa de Servicios Temporales)']);
        ProviderType::create(['type' => 'Outsourcing (BPO de RRHH)']);
        ProviderType::create(['type' => 'Headhunter (Caza Talentos)']);
        ProviderType::create(['type' => 'Consultoría (Selección de Personal)']);
        ProviderType::create(['type' => 'Formación (Capacitación)']);
        ProviderType::create(['type' => 'Otro (Servicios Especializados)']);
    }
}
