<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $main_company = Company::create([
            'company_name' => 'CONATEK',
            'company_type_id' => 2,
            'identification_type_id' => 3,
            'identification_number' => 123,
            'province_id' => 2,
            'city_id' => 135,
            'address' => 'San Antonio de Prado',
            'industry_type_id' => 7,
            'size' => 60,
            'founded_at' => '2021-01-01',
            'is_active' => 1,
            'description' => 'Empresa de tecnología',
        ]);

        $guest_company = Company::create([
            'company_name' => 'MUY HUMANO',
            'company_type_id' => 2,
            'identification_type_id' => 3,
            'identification_number' => 123,
            'province_id' => 2,
            'city_id' => 135,
            'address' => 'San Antonio de Prado',
            'industry_type_id' => 7,
            'size' => 60,
            'founded_at' => '2021-01-01',
            'is_active' => 1,
            'description' => 'Empresa de tecnología',
        ]);

        Company::factory()
                ->count(48)
                ->create();
    }
}
