<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $provinces = [
            ['province_code' => 128, 'province_name' => 'ILOCOS NORTE', 'region_code' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 129, 'province_name' => 'ILOCOS SUR', 'region_code' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 133, 'province_name' => 'LA UNION', 'region_code' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 155, 'province_name' => 'PANGASINAN', 'region_code' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 209, 'province_name' => 'BATANES', 'region_code' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 215, 'province_name' => 'CAGAYAN', 'region_code' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 231, 'province_name' => 'ISABELA', 'region_code' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 250, 'province_name' => 'NUEVA VIZCAYA', 'region_code' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 257, 'province_name' => 'QUIRINO', 'region_code' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 308, 'province_name' => 'BATAAN', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 314, 'province_name' => 'BULACAN', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 349, 'province_name' => 'NUEVA ECIJA', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 354, 'province_name' => 'PAMPANGA', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 369, 'province_name' => 'TARLAC', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 371, 'province_name' => 'ZAMBALES', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 377, 'province_name' => 'AURORA', 'region_code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 410, 'province_name' => 'BATANGAS', 'region_code' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 421, 'province_name' => 'CAVITE', 'region_code' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 434, 'province_name' => 'LAGUNA', 'region_code' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 456, 'province_name' => 'QUEZON', 'region_code' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 458, 'province_name' => 'RIZAL', 'region_code' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 505, 'province_name' => 'ALBAY', 'region_code' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 516, 'province_name' => 'CAMARINES NORTE', 'region_code' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 517, 'province_name' => 'CAMARINES SUR', 'region_code' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 520, 'province_name' => 'CATANDUANES', 'region_code' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 541, 'province_name' => 'MASBATE', 'region_code' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 562, 'province_name' => 'SORSOGON', 'region_code' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 604, 'province_name' => 'AKLAN', 'region_code' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 606, 'province_name' => 'ANTIQUE', 'region_code' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 619, 'province_name' => 'CAPIZ', 'region_code' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 630, 'province_name' => 'ILOILO', 'region_code' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 645, 'province_name' => 'NEGROS OCCIDENTAL', 'region_code' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 679, 'province_name' => 'GUIMARAS', 'region_code' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 712, 'province_name' => 'BOHOL', 'region_code' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 722, 'province_name' => 'CEBU', 'region_code' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 746, 'province_name' => 'NEGROS ORIENTAL', 'region_code' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 761, 'province_name' => 'SIQUIJOR', 'region_code' => 7, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 826, 'province_name' => 'EASTERN SAMAR', 'region_code' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 837, 'province_name' => 'LEYTE', 'region_code' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 848, 'province_name' => 'NORTHERN SAMAR', 'region_code' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 860, 'province_name' => 'SAMAR (WESTERN SAMAR)', 'region_code' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 864, 'province_name' => 'SOUTHERN LEYTE', 'region_code' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 878, 'province_name' => 'BILIRAN', 'region_code' => 8, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 972, 'province_name' => 'ZAMBOANGA DEL NORTE', 'region_code' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 973, 'province_name' => 'ZAMBOANGA DEL SUR', 'region_code' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 983, 'province_name' => 'ZAMBOANGA SIBUGAY', 'region_code' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 997, 'province_name' => 'CITY OF ISABELA', 'region_code' => 9, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1013, 'province_name' => 'BUKIDNON', 'region_code' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1018, 'province_name' => 'CAMIGUIN', 'region_code' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1035, 'province_name' => 'LANAO DEL NORTE', 'region_code' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1042, 'province_name' => 'MISAMIS OCCIDENTAL', 'region_code' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1043, 'province_name' => 'MISAMIS ORIENTAL', 'region_code' => 10, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1123, 'province_name' => 'DAVAO DEL NORTE', 'region_code' => 11, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1124, 'province_name' => 'DAVAO DEL SUR', 'region_code' => 11, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1125, 'province_name' => 'DAVAO ORIENTAL', 'region_code' => 11, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1182, 'province_name' => 'COMPOSTELA VALLEY', 'region_code' => 11, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1186, 'province_name' => 'DAVAO OCCIDENTAL', 'region_code' => 11, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1247, 'province_name' => 'COTABATO (NORTH COTABATO)', 'region_code' => 12, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1263, 'province_name' => 'SOUTH COTABATO', 'region_code' => 12, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1265, 'province_name' => 'SULTAN KUDARAT', 'region_code' => 12, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1280, 'province_name' => 'SARANGANI', 'region_code' => 12, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1298, 'province_name' => 'COTABATO CITY', 'region_code' => 12, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1339, 'province_name' => 'CITY OF MANILA', 'region_code' => 13, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1374, 'province_name' => 'NCR- SECOND DISTRICT', 'region_code' => 13, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1375, 'province_name' => 'NCR- THIRD DISTRICT', 'region_code' => 13, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1376, 'province_name' => 'NCR- FOURTH DISTRICT', 'region_code' => 13, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1400, 'province_name' => 'NCR- CITY OF MANILA- FIRST DISTRICT', 'region_code' => 13, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1401, 'province_name' => 'ABRA', 'region_code' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1411, 'province_name' => 'BENGUET', 'region_code' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1427, 'province_name' => 'IFUGAO', 'region_code' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1432, 'province_name' => 'KALINGA', 'region_code' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1444, 'province_name' => 'MOUNTAIN PROVINCE', 'region_code' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1481, 'province_name' => 'APAYAO', 'region_code' => 14, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1507, 'province_name' => 'BASILAN', 'region_code' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1536, 'province_name' => 'LANAO DEL SUR', 'region_code' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1538, 'province_name' => 'MAGUINDANAO', 'region_code' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1566, 'province_name' => 'SULU', 'region_code' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1570, 'province_name' => 'TAWI-TAWI', 'region_code' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1602, 'province_name' => 'AGUSAN DEL NORTE', 'region_code' => 16, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1603, 'province_name' => 'AGUSAN DEL SUR', 'region_code' => 16, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1667, 'province_name' => 'SURIGAO DEL NORTE', 'region_code' => 16, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1668, 'province_name' => 'SURIGAO DEL SUR', 'region_code' => 16, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1685, 'province_name' => 'DINAGAT ISLANDS', 'region_code' => 16, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1740, 'province_name' => 'MARINDUQUE', 'region_code' => 17, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1751, 'province_name' => 'OCCIDENTAL MINDORO', 'region_code' => 17, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1752, 'province_name' => 'ORIENTAL MINDORO', 'region_code' => 17, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1753, 'province_name' => 'PALAWAN', 'region_code' => 17, 'created_at' => $now, 'updated_at' => $now],
            ['province_code' => 1759, 'province_name' => 'ROMBLON', 'region_code' => 17, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('provinces')->insert($provinces);
    }
}
