<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdviserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('advisers')->insert([
            'teacher_id' => 'TCHR001',
            'grade_level' => '7',
            'section' => 'Rose',
            'school_year' => '2024-2025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
