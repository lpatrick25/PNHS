<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate incoming data
            $validated = $request->validate([
                'subject_listing' => 'required|integer',
            ]);

            $status = 'ABSENT';
            $subject_listing = $validated['subject_listing'];

            // Check if attendance for today has already been recorded
            $existingAttendance = DB::table('attendances')
                ->where('subject_listing', $subject_listing)
                ->where('attendance_date', now()->format('Y-m-d'))
                ->exists();

            if ($existingAttendance) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Attendance for this subject listing has already been recorded today.',
                ]);
            }

            // Find the subject listing assigned to the teacher
            $subjectListing = DB::table('subject_teachers')
                ->where('subject_listing', $subject_listing)
                ->first();

            if (!$subjectListing) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Subject listing not found for the given details.',
                ]);
            }

            // Check if the student is in the specified section and grade level
            $studentStatus = DB::table('student_statuses')
                ->where('grade_level', $subjectListing->grade_level)
                ->where('section', $subjectListing->section)
                ->where('school_year', $subjectListing->school_year)
                ->where('status', 'ENROLLED')
                ->get();

            if ($studentStatus->isEmpty()) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No students are enrolled in the specified section.',
                ]);
            }

            // Batch Insert attendance records
            $attendances = [];
            foreach ($studentStatus as $student) {
                $attendances[] = [
                    'student_lrn' => $student->student_lrn,
                    'subject_listing' => $subject_listing,
                    'school_year' => $student->school_year,
                    'attendance_date' => now()->format('Y-m-d'),
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('attendances')->insert($attendances);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Attendance added successfully.',
                'subject_listing' => $subject_listing,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error inserting attendance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to insert the attendance. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($subject_listing)
    {
        try {
            // Get the subject listings that this teacher is assigned to
            $subjectListings = SubjectTeacher::where('subject_listing', $subject_listing)
                ->pluck('subject_listing');  // Get the subject_listing IDs

            if ($subjectListings->isEmpty()) {
                return response()->json(['valid' => false, 'msg' => 'No subjects assigned to this teacher.'], 404);
            }

            // Fetch the attendance data for these subject listings
            $attendances = Attendance::whereIn('subject_listing', $subjectListings)
                ->selectRaw('attendance_date,
                            COUNT(CASE WHEN status = "PRESENT" THEN 1 END) AS number_of_present,
                            COUNT(CASE WHEN status = "LATE" THEN 1 END) AS number_of_late,
                            COUNT(CASE WHEN status = "ABSENT" THEN 1 END) AS number_of_absent')
                ->groupBy('attendance_date')
                ->orderBy('attendance_date', 'desc')
                ->get();

            // Format the response
            $response = $attendances->map(function ($attendance, $index) {
                return [
                    'count' => $index + 1,  // Add a simple index number
                    'attendance_date' => date('F j, Y', strtotime($attendance->attendance_date)),
                    'number_of_present' => $attendance->number_of_present,
                    'number_of_late' => $attendance->number_of_late,
                    'number_of_absent' => $attendance->number_of_absent,
                    'action' => '<button class="btn btn-primary btn-md" title="View Student" onClick="viewStudents(' . "'" . $attendance->attendance_date . "'" . ')"><i class="fa fa-eye"></i></button>'
                ];
            });

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching attendance data: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve attendance records at the moment. Please try again later.',
            ]);
        }
    }

    public function update(Request $request, $rfid_no)
    {
        DB::beginTransaction();

        try {
            // Validate incoming data
            $validated = $request->validate([
                'subject_listing' => 'required|integer',
                'attendance_date' => 'required|date',
            ]);

            $status = 'PRESENT';
            $subject_listing = $validated['subject_listing'];
            $attendance_date = $validated['attendance_date'];

            // Find the student by RFID number
            $student = DB::table('students')
                ->where('rfid_no', $rfid_no)
                ->first();

            if (!$student) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Student not found for the provided RFID number.',
                ]);
            }

            // Check if the attendance record exists
            $studentAttendance = DB::table('attendances')
                ->where('subject_listing', $subject_listing)
                ->where('attendance_date', $attendance_date)
                ->where('student_lrn', $student->student_lrn)
                ->first();

            if (!$studentAttendance) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Attendance record not found for the provided details.',
                ]);
            }

            // Update the attendance record
            DB::table('attendances')
                ->where('attendance_id', $studentAttendance->attendance_id)
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Attendance updated successfully.',
                'attendance_date' => $attendance_date,
                'subject_listing' => $subject_listing,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating attendance: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to update the attendance. Please try again later.',
            ]);
        }
    }

    public function getAttendanceByDate($attendance_date)
    {
        try {
            // Get the teacher's ID based on the logged-in user
            $teacher = Teacher::where('user_id', session('user_id'))->first();

            if (!$teacher) {
                return response()->json(['valid' => false, 'msg' => 'Teacher not found.'], 404);
            }

            $teacher_id = $teacher->teacher_id;

            // Get the subject listings assigned to this teacher
            $subjectListings = SubjectTeacher::where('teacher_id', $teacher_id)
                ->pluck('subject_listing');

            if ($subjectListings->isEmpty()) {
                return response()->json(['valid' => false, 'msg' => 'No subjects assigned to this teacher.'], 404);
            }

            // Fetch attendance data
            $attendances = Attendance::whereIn('subject_listing', $subjectListings)
                ->where('attendance_date', $attendance_date) // Filter by attendance_date
                ->join('students', 'students.student_lrn', '=', 'attendances.student_lrn')
                ->select(
                    'students.student_lrn',
                    'students.image',
                    DB::raw("CONCAT(
                        students.first_name,
                        ' ',
                        COALESCE(CONCAT(LEFT(students.middle_name, 1), '.'), ''),
                        ' ',
                        students.last_name
                        ) as student_name"),
                        'attendances.status as attendance_status'
                    )
                    ->orderByRaw("
                    CASE 
                        WHEN attendances.status = 'PRESENT' THEN 1
                        WHEN attendances.status = 'LATE' THEN 2
                        WHEN attendances.status = 'EXCUSED' THEN 3
                        ELSE 4
                    END
                    ") // Order by status priority
                ->get();

            if ($attendances->isEmpty()) {
                return response()->json(['valid' => false, 'msg' => 'No attendance records found for the given date.'], 404);
            }

            // Format the response
            $response = $attendances->map(function ($attendance, $index) {
                return [
                    'count' => $index + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($attendance->image) . '" style="width: 50px;">',
                    'student_lrn' => $attendance->student_lrn,
                    'student_name' => $attendance->student_name,
                    'attendance_status' => $attendance->attendance_status,
                ];
            });

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error fetching attendance data: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve attendance records at the moment. Please try again later.',
            ]);
        }
    }

    public function getStudentAttendance()
    {
        try {
            // Validate that the student exists
            $student = DB::table('students')->where('student_lrn', session('username'))->first();

            if (!$student) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Student not found.',
                ]);
            }

            // Fetch the student's attendance summary grouped by grade level and section
            $attendanceSummary = DB::table('attendances')
                ->join('subject_teachers', 'attendances.subject_listing', '=', 'subject_teachers.subject_listing')
                ->join('subjects', 'subject_teachers.subject_code', '=', 'subjects.subject_code')
                ->where('attendances.student_lrn', session('username'))
                ->select(
                    'subject_teachers.grade_level',
                    'subject_teachers.section',
                    'subjects.subject_code', // Include subject_code
                    'subjects.subject_name',
                    DB::raw('SUM(CASE WHEN attendances.status = "PRESENT" THEN 1 ELSE 0 END) as total_present'),
                    DB::raw('COUNT(attendances.attendance_id) as total_attendance')
                )
                ->groupBy('subject_teachers.grade_level', 'subject_teachers.section', 'subjects.subject_code', 'subjects.subject_name')
                ->orderBy('subject_teachers.grade_level')
                ->orderBy('subject_teachers.section')
                ->get();

            if ($attendanceSummary->isEmpty()) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No attendance records found for the student.',
                ]);
            }

            // Organize data by grade level and section
            $organizedData = $attendanceSummary->groupBy(function ($record) {
                return "{$record->grade_level}-{$record->section}";
            })->map(function ($group) {
                return [
                    'subjects' => $group->map(function ($record) {
                        return [
                            'subject_code' => $record->subject_code, // Include subject_code in the response
                            'subject_name' => $record->subject_name,
                            'attendance_summary' => "{$record->total_present} / {$record->total_attendance}",
                        ];
                    }),
                ];
            });

            // Format response
            $response = [];
            foreach ($organizedData as $groupKey => $data) {
                [$gradeLevel, $section] = explode('-', $groupKey);
                $response[] = [
                    'grade_level' => $gradeLevel,
                    'section' => $section,
                    'subjects' => $data['subjects'],
                ];
            }

            return response()->json([
                'valid' => true,
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching student attendance: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to retrieve student attendance. Please try again later.',
            ]);
        }
    }
}
