<?php

namespace Database\Seeders;

use App\Models\SocialStratum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialStratumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialStratum::create(['name' => '1-Bajo-Bajo']);
        SocialStratum::create(['name' => '2-Bajo']);
        SocialStratum::create(['name' => '3-Medio-Bajo']);
        SocialStratum::create(['name' => '4-Medio']);
        SocialStratum::create(['name' => '5-Medio-Alto']);
        SocialStratum::create(['name' => '6-Alto']);
    }
}
