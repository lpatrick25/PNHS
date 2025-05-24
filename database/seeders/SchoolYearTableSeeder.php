<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SchoolYearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_years')->insert([
            'school_year' => '2024-2025',
            'start_date' => Carbon::create(2024, 6, 1)->toDateString(), // Adjust as per your academic year start date
            'end_date' => Carbon::create(2025, 3, 31)->toDateString(), // Adjust as per your academic year end date
            'current' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
