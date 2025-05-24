<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'user_id' => 5,
                'username' => 'TCHR001',
                'password' => Hash::make('TCHR001'),
                'role' => 'teacher',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'username' => 'TCHR002',
                'password' => Hash::make('TCHR002'),
                'role' => 'teacher',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'username' => 'TCHR003',
                'password' => Hash::make('TCHR003'),
                'role' => 'teacher',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('teachers')->insert([
            [
                'teacher_id' => 'TCHR001',
                'user_id' => 5,
                'first_name' => 'Amelia',
                'middle_name' => 'Santos',
                'last_name' => 'De Guzman',
                'extension_name' => null,
                'province_code' => 837,
                'municipality_code' => 83701,
                'brgy_code' => 83701001,
                'zip_code' => 6510,
                'religion' => 'Roman Catholic',
                'birthday' => '1985-03-15',
                'sex' => 'Female',
                'civil_status' => 'Married',
                'email' => 'amelia.deguzman@gmail.com',
                'contact' => '(+63) 912-345-6789',
                'image' => 'dist/img/avatar2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' => 'TCHR002',
                'user_id' => 6,
                'first_name' => 'Benigno',
                'middle_name' => 'Reyes',
                'last_name' => 'Lopez',
                'extension_name' => null,
                'province_code' => 837,
                'municipality_code' => 83701,
                'brgy_code' => 83701002,
                'zip_code' => 6511,
                'religion' => 'Iglesia Ni Cristo',
                'birthday' => '1978-11-22',
                'sex' => 'Male',
                'civil_status' => 'Single',
                'email' => 'benigno.lopez@gmail.com',
                'contact' => '(+63) 917-654-3210',
                'image' => 'dist/img/avatar2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' => 'TCHR003',
                'user_id' => 7,
                'first_name' => 'Cecilia',
                'middle_name' => 'Torres',
                'last_name' => 'Garcia',
                'extension_name' => null,
                'province_code' => 837,
                'municipality_code' => 83701,
                'brgy_code' => 83701003,
                'zip_code' => 6512,
                'religion' => 'Born Again',
                'birthday' => '1990-07-08',
                'sex' => 'Female',
                'civil_status' => 'Widowed',
                'email' => 'cecilia.garcia@gmail.com',
                'contact' => '(+63) 928-111-2222',
                'image' => 'dist/img/avatar2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
