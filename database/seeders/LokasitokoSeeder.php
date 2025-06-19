<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasitokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lokasitoko')->insert([
            'lokasitoko_id' => 35096,
            'label' => 'BUKIT SEBURI II, ADONARA BARAT, FLORES TIMUR, NUSA TENGGARA TIMUR (NTT), 86262',
            'province_name' => 'NUSA TENGGARA TIMUR (NTT)',
            'city_name' => 'FLORES TIMUR',
            'district_name' => 'ADONARA BARAT',
            'subdistrict_name' => 'BUKIT SEBURI II',
            'zip_code' => '86262'
        ]);
    }
}
