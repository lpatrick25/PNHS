<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('student_statuses')->insert([
            'student_lrn' => '123456789101',
            'adviser_id' => '1',
            'grade_level' => '7',
            'school_year' => '2024-2025',
            'section' => 'Rose',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('student_statuses')->insert([
            'student_lrn' => '123456789102',
            'adviser_id' => '1',
            'grade_level' => '7',
            'school_year' => '2024-2025',
            'section' => 'Rose',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('student_statuses')->insert([
            'student_lrn' => '123456789103',
            'adviser_id' => '1',
            'grade_level' => '7',
            'school_year' => '2024-2025',
            'section' => 'Rose',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
