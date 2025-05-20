<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('campuses')->insert([
            [
                'company_id' => 1,
                'province_id' => 2,
                'city_id' => 135,
                'name' => 'Medellín',
                'address' => 'Calle 123 #45-67',
                'phone' => '3001234567',
                'email' => 'medellin@empresa.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'province_id' => 6,
                'city_id' => 169,
                'name' => 'Bogotá',
                'address' => 'Av. Norte 89-10',
                'phone' => '3012345678',
                'email' => 'bogota@empresa.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'province_id' => 31,
                'city_id' => 1100,
                'name' => 'Cali',
                'address' => 'Carrera 10 #12-34',
                'phone' => '3023456789',
                'email' => 'cali@empresa.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_id' => 1,
                'province_id' => 5,
                'city_id' => 146,
                'name' => 'Barranquilla',
                'address' => 'Diagonal 45 #67-89',
                'phone' => '3034567890',
                'email' => 'barranquilla@empresa.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}

