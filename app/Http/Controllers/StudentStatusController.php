<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\StudentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StudentStatusController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate incoming data
            $school_year = session('school_year');
            $validated = $request->validate([
                'student_lrn' => [
                    'required',
                    'exists:students,student_lrn',
                    Rule::unique('student_statuses')->where(function ($query) use ($school_year) {
                        return $query->where('school_year', $school_year);
                    }),
                ],
                'adviser_id' => ['required', 'exists:advisers,adviser_id'],
            ]);

            // Fetch adviser details
            $adviser = Adviser::where('adviser_id', $validated['adviser_id'])
                ->where('school_year', $school_year)
                ->firstOrFail();

            // Create a new student status record
            $studentStatus = StudentStatus::create([
                'student_lrn' => $validated['student_lrn'],
                'adviser_id' => $validated['adviser_id'],
                'grade_level' => $adviser->grade_level,
                'school_year' => $adviser->school_year,
                'section' => $adviser->section,
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Student added successfully.',
                'data' => $studentStatus,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating student:', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the student. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($adviser_id)
    {
        try {
            // Fetch students associated with the given adviser
            $students = DB::table('student_statuses')
                ->join('students', 'students.student_lrn', '=', 'student_statuses.student_lrn')
                ->select(
                    'students.student_lrn',
                    DB::raw("
                    CONCAT(
                        students.first_name,
                        ' ',
                        COALESCE(CONCAT(LEFT(students.middle_name, 1), '.'), ''),
                        ' ',
                        students.last_name
                    ) as student_name
                "),
                    'students.image as student_image'
                )
                ->where('student_statuses.adviser_id', $adviser_id)
                ->get();

            // Format the response
            $response = $students->map(function ($student, $key) {
                return [
                    'count' => $key + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($student->student_image) . '" style="width: 50px;">',
                    'student_lrn' => $student->student_lrn,
                    'student_name' => $student->student_name,
                    'action' => '
                    <button class="btn btn-danger btn-md" title="Remove" onclick="remove(' . "'" . $student->student_lrn . "'" . ')"><i class="fa fa-trash"></i></button>
                ',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching students: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve student records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentStatus $studentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $student_lrn The LRN of the student to be removed.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function destroy($student_lrn)
    {
        DB::beginTransaction(); // Start a database transaction
        try {
            // Get the current school year from session
            $school_year = session('school_year');
            if (!$school_year) {
                throw new \Exception("School year not set in session.");
            }

            // Find the student status record for the given LRN and school year
            $studentStatus = StudentStatus::where('student_lrn', $student_lrn)
                ->where('school_year', $school_year)
                ->first();

            // Check if the record exists
            if (!$studentStatus) {
                throw new \Exception("Student with LRN $student_lrn for school year $school_year not found.");
            }

            // Delete the student status record
            $studentStatus->delete();

            DB::commit(); // Commit the transaction

            return response()->json([
                'valid' => true,
                'msg' => 'Student removed successfully.',
                'data' => $studentStatus, // Return the deleted student record for confirmation
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            // Log the error for debugging purposes
            Log::error('Error removing student: ' . $e->getMessage(), [
                'student_lrn' => $student_lrn,
                'school_year' => $school_year ?? 'N/A',
            ]);

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to remove the student. Please try again later.',
            ]);
        }
    }
}
