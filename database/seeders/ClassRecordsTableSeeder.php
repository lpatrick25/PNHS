<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $students = [
            '123456789101',
            '123456789102',
            '123456789103'
        ];

        $schoolYear = '2024-2025';
        $totalScoreWrittenWorks = 30;
        $totalScorePerformanceTasks = 30;
        $totalScoreQuarterlyAssessment = 50;

        $writtenWorksCount = 10;
        $performanceTasksCount = 10;

        $quarterKeys = [
            "1st Quarter",
            "2nd Quarter",
            "3rd Quarter",
            "4th Quarter",
        ];

        foreach ($students as $studentLrn) {
            foreach ($quarterKeys as $quarterName) {
                // Insert Written Works
                for ($i = 1; $i <= $writtenWorksCount; $i++) {

                    for ($subjectListing = 1; $subjectListing <= 3; $subjectListing++) {
                        DB::table('class_records')->insert([
                            'records_name' => "Written Work $i",
                            'student_lrn' => $studentLrn,
                            'subject_listing' => $subjectListing,
                            'school_year' => $schoolYear,
                            'total_score' => $totalScoreWrittenWorks,
                            'student_score' => rand(15, 30), // Random student score
                            'records_type' => 'Written Works',
                            'quarter' => $quarterName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // Insert Performance Tasks
                for ($i = 1; $i <= $performanceTasksCount; $i++) {

                    for ($subjectListing = 1; $subjectListing <= 3; $subjectListing++) {
                        DB::table('class_records')->insert([
                            'records_name' => "Performance Task $i",
                            'student_lrn' => $studentLrn,
                            'subject_listing' => $subjectListing,
                            'school_year' => $schoolYear,
                            'total_score' => $totalScorePerformanceTasks,
                            'student_score' => rand(15, 30), // Random student score
                            'records_type' => 'Performance Tasks',
                            'quarter' => $quarterName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                for ($subjectListing = 1; $subjectListing <= 3; $subjectListing++) {
                    // Insert Quarterly Assessment
                    DB::table('class_records')->insert([
                        'records_name' => $quarterName . ' Assessment',
                        'student_lrn' => $studentLrn,
                        'subject_listing' => $subjectListing,
                        'school_year' => $schoolYear,
                        'total_score' => $totalScoreQuarterlyAssessment,
                        'student_score' => rand(40, 50), // Random student score
                        'records_type' => 'Quarterly Assessment',
                        'quarter' => $quarterName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
