<?php

namespace App\Http\Controllers;

use App\Models\SubjectTeacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubjectTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'subject_code' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,teacher_id', // Ensure teacher exists
            'grade_level' => 'required|integer',
            'section' => 'required|string|max:255',
            'school_year' => 'required|string|regex:/^\d{4}-\d{4}$/', // Validate format (e.g., 2023-2024)
        ]);

        DB::beginTransaction();

        try {
            // Authorization check (if applicable)
            // $this->authorize('create', SubjectTeacher::class);

            // Check for duplicates for the same teacher
            $existsForTeacher = SubjectTeacher::where('teacher_id', $validated['teacher_id'])
                ->where('grade_level', $validated['grade_level'])
                ->where('section', $validated['section'])
                ->where('school_year', $validated['school_year'])
                ->exists();

            if ($existsForTeacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'This teacher is already assigned to this subject, grade level, and section for the current school year.',
                ]); // Return 400 Bad Request
            }

            // Check for conflicts with other teachers
            $conflictWithOtherTeacher = SubjectTeacher::where('subject_code', $validated['subject_code'])
                ->where('grade_level', $validated['grade_level'])
                ->where('section', $validated['section'])
                ->where('school_year', $validated['school_year'])
                ->exists();

            if ($conflictWithOtherTeacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Another teacher is already assigned to this subject, grade level, and section for the current school year.',
                ]); // Return 400 Bad Request
            }

            // Create the subject record
            $subjectTeacher = SubjectTeacher::create($validated);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Subject teacher added successfully.',
                'data' => $subjectTeacher,
            ]); // Return 201 Created
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Database error while creating subject teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Database error occurred. Please contact support.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unexpected error while creating subject teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($teacher_id)
    {
        try {
            $subjectTeacher = DB::table('subject_teachers')
                ->join('teachers', 'teachers.teacher_id', '=', 'subject_teachers.teacher_id')
                ->join('subjects', 'subjects.subject_code', '=', 'subject_teachers.subject_code')
                ->where('subject_teachers.school_year', session('school_year'))
                ->where('subject_teachers.teacher_id', $teacher_id)
                ->select(
                    'subject_teachers.subject_listing',
                    'subject_teachers.school_year',
                    'subject_teachers.grade_level',
                    'subject_teachers.section',
                    'subjects.subject_name',
                    'subjects.subject_code',
                    DB::raw("
                    CONCAT(
                        teachers.first_name,
                        ' ',
                        COALESCE(CONCAT(LEFT(teachers.middle_name, 1), '.'), ''),
                        ' ',
                        teachers.last_name
                    ) as teacher_name
                ")
                )
                ->get();

            $response = $subjectTeacher->map(function ($list, $key) {
                return [
                    'count' => $key + 1,
                    'teacher_name' => $list->teacher_name,
                    'subject_code' => $list->subject_code,
                    'subject_name' => $list->subject_name,
                    'grade_level' => '<span class="text-success" style="font-weight: bolder;">Grade ' . $list->grade_level . '</span>',
                    'section' => '<span class="text-danger" style="font-weight: bolder;">' . $list->section . '</span>',
                    'school_year' => $list->school_year,
                    'action' => session('role') === "admin" ?
                        '<button type="button" class="btn btn-md btn-danger" title="Update" onclick="trash(\'' . addslashes($list->subject_listing) . '\')"><i class="fa fa-trash"></i></button>' :
                        '<button type="button" class="btn btn-md btn-primary" title="View Students" onclick="view(\'' . addslashes($list->subject_listing) . '\')"><i class="fa fa-eye"></i></button>',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching subject teachers: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve subject teacher records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $subject_listing)
    {
        try {
            // Validate incoming data
            $validated = $request->validate([
                'subject_code' => 'required',
                'teacher_id' => 'required',
                'grade_level' => 'required',
                'section' => 'required',
                'school_year' => 'required',
            ]);

            $subjectTeacher = SubjectTeacher::where('subject_listing', $subject_listing)->first();

            if (!$subjectTeacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
                ]);
            }

            $subjectTeacher->update([
                'subject_code' => $validated['subject_code'],
                'teacher_id' => $validated['teacher_id'],
                'grade_level' => $validated['grade_level'],
                'section' => $validated['section'],
                'school_year' => $validated['school_year'],
            ]);

            return response()->json([
                'valid' => true,
                'msg' => 'Subject teacher updated successfully.',
                'data' => $subjectTeacher,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating subject teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to update subject records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subject_listing)
    {
        try {
            $subjectTeacher = SubjectTeacher::where('subject_listing', $subject_listing)->first();

            if (!$subjectTeacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
                ]);
            }

            $subjectTeacher->delete();

            return response()->json([
                'valid' => true,
                'msg' => 'Subject teacher deleted successfully.',
                'data' => $subjectTeacher,
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting subject teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to delete subject teacher records at the moment. Please try again later.',
            ]);
        }
    }

    public function getEnrolledStudent($subject_listing)
    {
        try {
            $subjectTeacher = SubjectTeacher::where('subject_listing', $subject_listing)->first();

            if (!$subjectTeacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
                ]);
            }

            $students = DB::table('student_statuses')
                ->join('students', 'students.student_lrn', '=', 'student_statuses.student_lrn')
                ->where('student_statuses.grade_level', $subjectTeacher->grade_level)
                ->where('student_statuses.section', $subjectTeacher->section)
                ->where('student_statuses.school_year', $subjectTeacher->school_year)
                ->select(
                    'students.student_lrn','students.image',
                    DB::raw("
                CONCAT(
                    students.first_name,
                    ' ',
                    COALESCE(CONCAT(LEFT(students.middle_name, 1), '.'), ''),
                    ' ',
                    students.last_name
                ) as student_name
            ")
                )
                ->get();

            $response = $students->map(function ($list, $key) {
                return [
                    'count' => $key + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($list->image) . '" style="width: 50px;">',
                    'student_lrn' => '<span class="text-danger" style="font-weight: bolder;">' . $list->student_lrn . '</span>',
                    'student_name' => '<span class="text-danger" style="font-weight: bolder;">' . $list->student_name . '</span>',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching subject teachers: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve subject teacher records at the moment. Please try again later.',
            ]);
        }
    }
}
