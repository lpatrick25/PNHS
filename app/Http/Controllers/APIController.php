<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getStudentByRFID($rfid_no)
    {
        try {
            $student = Student::where('rfid_no', $rfid_no)->first();

            if (!$student) {
                throw new \Exception('Failed to retrieve student\'s information.');
            }

            // Append full URL for the image
            if (!empty($student->image)) {
                $student->image = url($student->image); // Full URL for the image
            } else {
                $student->image = url('dist/img/avatar5.png'); // Default placeholder image
            }

            return response()->json($student);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to retrieve student\'s information.'], 422);
        }
    }
}
