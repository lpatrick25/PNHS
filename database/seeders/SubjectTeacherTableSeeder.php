<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subject_teachers')->insert([
            'subject_code' => 'AP',
            'teacher_id' => 'TCHR001',
            'school_year' => '2024-2025',
            'grade_level' => '7',
            'section' => 'Rose',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('subject_teachers')->insert([
            'subject_code' => 'ESP',
            'teacher_id' => 'TCHR002',
            'school_year' => '2024-2025',
            'grade_level' => '7',
            'section' => 'Rose',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('subject_teachers')->insert([
            'subject_code' => 'ENGL',
            'teacher_id' => 'TCHR003',
            'school_year' => '2024-2025',
            'grade_level' => '7',
            'section' => 'Rose',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
