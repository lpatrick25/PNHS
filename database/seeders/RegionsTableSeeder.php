<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        $regions = [
            ['region_code' => 1, 'region_name' => 'REGION I (ILOCOS REGION)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 2, 'region_name' => 'REGION II (CAGAYAN VALLEY)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 3, 'region_name' => 'REGION III (CENTRAL LUZON)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 4, 'region_name' => 'REGION IV-A (CALABARZON)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 5, 'region_name' => 'REGION V (BICOL REGION)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 6, 'region_name' => 'REGION VI (WESTERN VISAYAS)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 7, 'region_name' => 'REGION VII (CENTRAL VISAYAS)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 8, 'region_name' => 'REGION VIII (EASTERN VISAYAS)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 9, 'region_name' => 'REGION IX (ZAMBOANGA PENINSULA)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 10, 'region_name' => 'REGION X (NORTHERN MINDANAO)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 11, 'region_name' => 'REGION XI (DAVAO REGION)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 12, 'region_name' => 'REGION XII (SOCCSKSARGEN)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 13, 'region_name' => 'NATIONAL CAPITAL REGION (NCR)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 14, 'region_name' => 'CORDILLERA ADMINISTRATIVE REGION (CAR)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 15, 'region_name' => 'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 16, 'region_name' => 'REGION XIII (Caraga)', 'created_at' => $now, 'updated_at' => $now],
            ['region_code' => 17, 'region_name' => 'REGION IV-B (MIMAROPA)', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('regions')->insert($regions);
    }
}
