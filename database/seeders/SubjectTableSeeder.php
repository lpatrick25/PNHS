<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'subject_code' => 'AP',
                'subject_name' => 'Araling Panlipunan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'ESP',
                'subject_name' => 'Edukasyon sa Pagpapakatao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'ENGL',
                'subject_name' => 'English',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'FIL',
                'subject_name' => 'Filipino',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'MATH',
                'subject_name' => 'Mathematics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'SCI',
                'subject_name' => 'Science',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'TLE',
                'subject_name' => 'TLE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_code' => 'MAPEH',
                'subject_name' => 'Mapeh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
