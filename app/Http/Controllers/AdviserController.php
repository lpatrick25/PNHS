<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdviserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the advisers with their students.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Fetch advisers and their associated teachers
            $advisers = DB::table('advisers')
                ->join('teachers', 'teachers.teacher_id', '=', 'advisers.teacher_id')
                ->select(
                    'advisers.*',
                    DB::raw("
                    CONCAT(
                        teachers.first_name,
                        ' ',
                        IF(teachers.middle_name IS NOT NULL AND teachers.middle_name != '', CONCAT(LEFT(teachers.middle_name, 1), '.'), ''),
                        ' ',
                        teachers.last_name
                    ) as adviser_name
                ")
                )
                ->get();

            // Map through advisers to add student details
            $response = $advisers->map(function ($list, $key) {
                // Fetch students for the current adviser's advisory
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
                    ")
                    )
                    ->where('student_statuses.adviser_id', $list->adviser_id)
                    ->where('student_statuses.status', 'ENROLLED')
                    ->get();

                // Format the adviser data with student list
                return [
                    'count' => $key + 1,
                    'adviser_name' => $list->adviser_name,
                    'grade_level' => '<span class="text-success">Grade ' . $list->grade_level . '</span>',
                    'section' => ucfirst($list->section),
                    'students' => '<span class="text-primary">' . count($students) . ' Students</span>',
                    'action' => '
                    <button class="btn btn-primary btn-md" title="Edit" onclick="edit(' . "'" . $list->adviser_id . "'" . ')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-success btn-md" title="Add Student" onclick="add_student(' . "'" . $list->adviser_id . "'" . ')"><i class="fa fa-user-plus"></i></button>
                ',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error fetching advisers: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve adviser records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate incoming data
            $validated = $request->validate([
                'teacher_id' => 'required',
                'grade_level' => 'required',
                'section' => 'required',
            ]);

            // Normalize section input
            $section = ucfirst(strtolower(trim($validated['section'])));

            // Check if the teacher already has an advisory for the current school year
            $existingAdviser = Adviser::where('teacher_id', $validated['teacher_id'])
                ->where('school_year', session('school_year'))
                ->first();

            if ($existingAdviser) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'This teacher is already assigned as an adviser for the current school year.',
                ]);
            }

            // Check if the section is already assigned to another adviser for the current school year
            $sectionTaken = Adviser::where('section', $section)
                ->where('grade_level', $validated['grade_level'])
                ->where('school_year', session('school_year'))
                ->first();

            if ($sectionTaken) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'This section is already assigned to an adviser for the current school year.',
                ]);
            }

            // Create a new adviser record
            $adviser = Adviser::create([
                'teacher_id' => $validated['teacher_id'],
                'grade_level' => $validated['grade_level'],
                'section' => $section,
                'school_year' => session('school_year'),
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Adviser added successfully.',
                'data' => $adviser,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating adviser: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the adviser. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($adviser_id)
    {
        try {
            $adviser = DB::table('advisers')
            ->join('teachers', 'teachers.teacher_id', '=', 'advisers.teacher_id')
                ->select(
                    'advisers.*',
                    DB::raw("
                    CONCAT(
                        teachers.first_name,
                        ' ',
                        IF(teachers.middle_name IS NOT NULL AND teachers.middle_name != '', CONCAT(LEFT(teachers.middle_name, 1), '.'), ''),
                        ' ',
                        teachers.last_name
                    ) as adviser_name
                ")
                )
            ->first();

            return response()->json($adviser);
        } catch (\Exception $e) {
            Log::error('Error fetching adviser details: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve the adviser details at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adviser $adviser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adviser $adviser)
    {
        //
    }

    public function getAdviserByGradeLevel($grade_level)
    {
        try {
            $advisers = Adviser::where('grade_level', $grade_level)->get();

            return response()->json($advisers);
        } catch (\Exception $e) {
            Log::error('Error fetching adviser details: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve the adviser details at the moment. Please try again later.',
            ]);
        }
    }
}
