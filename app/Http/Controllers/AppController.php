<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Attendance;
use App\Models\ClassRecord;
use App\Models\Principal;
use App\Models\Student;
use App\Models\StudentStatus;
use App\Models\SubjectTeacher;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppController extends Controller
{
    // Login Page
    public function getLoginPage()
    {
        return view('index');
    }

    //Admin Controller

    public function viewDashboardAdmin()
    {
        $dashboard = [
            'principals' => DB::table('principals')->count(),
            'students' => DB::table('students')->count(),
            'teachers' => DB::table('teachers')->count(),
            'users' => DB::table('users')->count(),
            'advisers' => DB::table('advisers')->count(),
        ];
        return view('admin.dashboard', compact('dashboard'));
    }

    public function viewUsers()
    {
        return view('admin.users');
    }

    public function viewStudents()
    {
        return view('admin.view_students');
    }

    public function viewAddStudent()
    {
        return view('admin.add_students');
    }

    public function viewStudent($student_lrn)
    {

        $student = Student::where('student_lrn', $student_lrn)->first();

        if (!$student) {
            return view('admin.view_students');
        }

        return view('admin.update_students', compact('student_lrn'));
    }

    public function viewTeachers()
    {
        return view('admin.view_teachers');
    }

    public function viewAddTeacher()
    {
        $teacher = Teacher::all();
        $teacherID = '';
        // $teacherID = 'Teacher' . date('-Y-') . sprintf('%04d', count($teacher) + 1);
        return view('admin.add_teachers', compact('teacherID'));
    }

    public function viewTeacher($teacher_id)
    {

        $student = Teacher::where('teacher_id', $teacher_id)->first();

        if (!$student) {
            return view('admin.view_teachers');
        }

        return view('admin.update_teachers', compact('teacher_id'));
    }

    public function viewPrincipals()
    {
        return view('admin.view_principals');
    }

    public function viewAddPrincipal()
    {
        $principal = Principal::all();
        $principalID = '';
        // $principalID = 'Principal' . date('-Y-') . sprintf('%04d', count($principal) + 1);
        return view('admin.add_principals', compact('principalID'));
    }

    public function viewPrincipal($principal_id)
    {

        $student = Principal::where('principal_id', $principal_id)->first();

        if (!$student) {
            return view('admin.view_principals');
        }

        return view('admin.update_principals', compact('principal_id'));
    }

    public function viewAdvisers()
    {
        $school_year = session('school_year');

        // Retrieve all teachers
        $teachers = Teacher::all();

        // Retrieve all students without advisories for the current school year
        $studentsWithoutAdvisories = Student::whereDoesntHave('studentStatuses', function ($query) use ($school_year) {
            $query->where('school_year', $school_year);
        })->get();

        return view('admin.advisers', compact('teachers', 'studentsWithoutAdvisories'));
    }

    public function viewSubjectList()
    {
        return view('admin.subjects');
    }

    public function viewSubjectTeacherList()
    {
        // Fetch subjects and remove duplicates based on 'subject_name'
        $subjects = Subject::all()->unique('subject_name');

        return view('admin.subject_teachers', compact('subjects'));
    }

    public function subjectTeachersList()
    {
        try {
            $teachers = Teacher::all();

            $response = $teachers->map(function ($teacher, $key) {
                return [
                    'count' => $key + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($teacher->image) . '" style="width: 50px;">',
                    'teacher_id' => $teacher->teacher_id,
                    'teacher_name' => trim($teacher->first_name . ' ' . ($teacher->middle_name ?? '') . ' ' . $teacher->last_name . ' ' . ($teacher->extension_name ?? '')),
                    'contact' => $teacher->contact,
                    'email' => $teacher->email,
                    'action' => '<button onclick="view(' . "'" . $teacher->teacher_id . "'" . ')" type="button" class="btn btn-md btn-primary" title="View"><i class="fa fa-edit"></i></button>',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching teachers: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve teacher records at the moment. Please try again later.',
            ]);
        }
    }

    public function viewSettings()
    {
        return view('admin.settings');
    }

    //Principal Controller

    public function viewDashboardPrincipal()
    {
        return view('principal.dashboard');
    }

    public function viewTeacherList()
    {
        return view('principal.teachers');
    }

    public function viewStudentList()
    {
        return view('principal.students');
    }

    //Teacher Controller

    public function viewDashboardTeacher()
    {
        try {
            // Retrieve the current user using the session's user_id
            $user = User::where('user_id', session()->get('user_id'))->firstOrFail();
            $username = $user->username;

            // Check if the user is using the default password
            if (Auth::attempt(['username' => $username, 'password' => $username])) {
                return view('password_change');
            }

            // Retrieve teacher info
            $teacherInfo = Teacher::where('user_id', session()->get('user_id'))->first();
            if (!$teacherInfo) {
                throw new \Exception('Teacher information not found.');
            }

            // Retrieve adviser info
            $adviserInfo = Adviser::where('teacher_id', $teacherInfo->teacher_id)->first();
            if (!$adviserInfo) {
                throw new \Exception('Adviser information not found.');
            }

            // Get subject listing for the current school year
            $subjectListing = SubjectTeacher::where('school_year', session()->get('school_year'))
                ->where('teacher_id', $teacherInfo->teacher_id)
                ->get();

            // Count the number of students in the adviser's class
            $studentList = StudentStatus::where('adviser_id', $adviserInfo->adviser_id)->count();

            // Calculate the total attendance count for subjects assigned to the teacher
            $attendanceCount = 0;
            foreach ($subjectListing as $subject) {
                $attendanceCount += Attendance::where('subject_listing', $subject->subject_listing)->count();
            }

            // Prepare the dashboard data
            $dashboard = [
                'advisory' => $adviserInfo,
                'student_list' => $studentList,
                'subject_list' => $subjectListing->count(),
                'attendance_count' => $attendanceCount,
            ];

            // Render the teacher dashboard view
            return view('teacher.dashboard', compact('dashboard'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where user is not found
            Log::warning('User not found during password check: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'User not found. Please ensure you are logged in.',
            ], 404);
        } catch (\Exception $e) {
            // Handle other exceptions
            Log::error('Error in viewDashboardTeacher: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred. Please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function viewAdvisory()
    {
        return view('teacher.advisory');
    }

    public function getAdvisoryStudents(Request $request)
    {
        try {
            $teacherId = Auth::user()->teacher->teacher_id;
            $schoolYear = session('school_year');

            // Fetch advisories for the teacher in the current school year
            $advisories = Adviser::where('teacher_id', $teacherId)
                ->where('school_year', $schoolYear)
                ->pluck('adviser_id');

            // Fetch student statuses linked to those advisories
            $studentsWithStatuses = StudentStatus::whereIn('adviser_id', $advisories)
                ->with('student') // Include related student details
                ->get();

            // Prepare response
            $response = $studentsWithStatuses->map(function ($status, $key) {
                $student = $status->student;
                return [
                    'count' => $key + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="Student Avatar" src="' . asset($student->image) . '" style="width: 50px;">',
                    'student_lrn' => $student->student_lrn,
                    'student_name' => strtoupper(trim($student->first_name . ' ' . ($student->middle_name ?? '') . ' ' . $student->last_name . ' ' . ($student->extension_name ?? ''))),
                    'status' => $status->status,
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching advisory students: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve advisory students at the moment. Please try again later.',
            ]);
        }
    }

    public function viewTeacherSubject()
    {
        $teacher = Teacher::where('user_id', session('user_id'))->first();
        $teacher_id = $teacher->teacher_id;
        return view('teacher.subjects', compact('teacher_id'));
    }

    public function viewAttendanceTeacher()
    {
        $teacher = Teacher::where('user_id', session('user_id'))->first();
        $teacher_id = $teacher->teacher_id;

        return view('teacher.attendances', compact('teacher_id'));
    }

    public function viewAddAttendance()
    {
        try {
            $teacherId = Auth::user()->teacher->teacher_id;
            $schoolYear = session('school_year');

            // Fetch advisories for the teacher in the current school year
            $advisories = Adviser::where('teacher_id', $teacherId)
                ->where('school_year', $schoolYear)
                ->pluck('adviser_id');

            // Fetch student statuses with related student details for those advisories
            $studentsWithStatuses = StudentStatus::whereIn('adviser_id', $advisories)
                ->with(['student' => function ($query) {
                    $query->select('student_lrn', 'first_name', 'middle_name', 'last_name', 'extension_name', 'image');
                }])
                ->get();

            // Prepare response data
            $studentList = $studentsWithStatuses->map(function ($status, $key) {
                $student = $status->student;

                return [
                    'count' => $key + 1,
                    'image' => asset($student->image),
                    'student_lrn' => $student->student_lrn,
                    'student_name' => strtoupper(trim($student->first_name . ' ' . ($student->middle_name ?? '') . ' ' . $student->last_name . ' ' . ($student->extension_name ?? '')))
                ];
            });

            return view('teacher.add_attendance', ['studentList' => $studentList]);
        } catch (\Exception $e) {
            Log::error('Error fetching advisory students: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'Unable to retrieve advisory students at the moment. Please try again later.',
            ]);
        }
    }

    public function viewClassRecordTeacher()
    {
        $teacher = Teacher::where('user_id', session('user_id'))->first();
        $teacher_id = $teacher->teacher_id;
        return view('teacher.classrecords', compact('teacher_id'));
    }

    public function viewClassRecord($subject_listing)
    {
        try {
            // Fetch Subject Teacher Details
            $subjectTeacher = DB::table('subject_teachers')
                ->join('teachers', 'teachers.teacher_id', '=', 'subject_teachers.teacher_id')
                ->join('subjects', 'subjects.subject_code', '=', 'subject_teachers.subject_code')
                ->where('subject_teachers.subject_listing', $subject_listing)
                ->select(
                    'subject_teachers.subject_listing',
                    'subject_teachers.school_year',
                    'subject_teachers.grade_level',
                    'subject_teachers.section',
                    'subjects.subject_code',
                    'subjects.subject_name'
                )
                ->first();

            if (!$subjectTeacher) {
                return redirect()->back()->withErrors([
                    'error' => 'Subject Teacher not found.',
                ]);
            }

            // Fetch Existing Class Records
            $existingClassRecords = DB::table('class_records')
                ->where('subject_listing', $subjectTeacher->subject_listing)
                ->get()
                ->groupBy('quarter');

            // Fetch Enrolled Students
            $subjectTeacherStudent = DB::table('subject_teachers')
                ->join('student_statuses', function ($join) {
                    $join->on('subject_teachers.school_year', '=', 'student_statuses.school_year')
                        ->on('subject_teachers.section', '=', 'student_statuses.section')
                        ->on('subject_teachers.grade_level', '=', 'student_statuses.grade_level');
                })
                ->join('students', 'student_statuses.student_lrn', '=', 'students.student_lrn')
                ->where('subject_teachers.subject_listing', $subjectTeacher->subject_listing)
                ->orderBy('students.last_name', 'asc')
                ->select('students.student_lrn', 'subject_teachers.school_year', 'students.sex') // Include gender
                ->get()
                ->sortBy(function ($student) {
                    return $student->sex === 'Male' ? 0 : 1; // Prioritize males (0 for male, 1 for others)
                });

            // Handle Class Record Generation
            foreach ($subjectTeacherStudent as $student) {
                // Check if student has records for all quarters
                $studentRecords = $existingClassRecords->flatMap(function ($records) use ($student) {
                    return $records->where('student_lrn', $student->student_lrn);
                });

                // Generate 1st Quarter if no records exist
                if ($studentRecords->isEmpty()) {
                    $this->generateClassRecord($subjectTeacher->subject_listing, $student->student_lrn, '1st Quarter', $student->school_year);
                }

                // Generate the next quarter if Quarterly Assessment is graded
                foreach (['1st Quarter', '2nd Quarter', '3rd Quarter'] as $quarter) {
                    if (
                        $studentRecords->where('quarter', $quarter)->isNotEmpty() &&
                        $studentRecords->where('quarter', $quarter)
                        ->where('records_type', 'Quarterly Assessment')
                        ->where('student_score', '>', 0)
                        ->isNotEmpty()
                    ) {
                        $nextQuarter = $this->getNextQuarter($quarter);
                        if ($nextQuarter && $studentRecords->where('quarter', $nextQuarter)->isEmpty()) {
                            $this->generateClassRecord($subjectTeacher->subject_listing, $student->student_lrn, $nextQuarter, $student->school_year);
                        }
                    }
                }

                // Add records for late enrollees
                foreach ($existingClassRecords as $quarter => $records) {
                    $studentQuarterRecords = $records->where('student_lrn', $student->student_lrn);
                    if ($studentQuarterRecords->isEmpty()) {
                        $this->generateClassRecord($subjectTeacher->subject_listing, $student->student_lrn, $quarter, $student->school_year);
                    }
                }
            }

            return view('teacher.view_class_records', compact('subjectTeacher'));
        } catch (\Exception $e) {
            Log::error('Error fetching advisory students: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'Unable to retrieve advisory students at the moment. Please try again later.',
            ]);
        }
    }

    private function generateClassRecord($subjectListing, $studentLrn, $quarter, $schoolYear)
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('class_records')->insert([
                'records_name' => 'Written Works ' . $i,
                'student_lrn' => $studentLrn,
                'subject_listing' => $subjectListing,
                'school_year' => $schoolYear,
                'total_score' => null, // or your default score
                'student_score' => 0,
                'records_type' => 'Written Works',
                'quarter' => $quarter,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('class_records')->insert([
                'records_name' => 'Performance Tasks ' . $i,
                'student_lrn' => $studentLrn,
                'subject_listing' => $subjectListing,
                'school_year' => $schoolYear,
                'total_score' => null, // or your default score
                'student_score' => 0,
                'records_type' => 'Performance Tasks',
                'quarter' => $quarter,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('class_records')->insert([
            'records_name' => 'Quarterly Assessment',
            'student_lrn' => $studentLrn,
            'subject_listing' => $subjectListing,
            'school_year' => $schoolYear,
            'total_score' => null, // or your default score
            'student_score' => 0,
            'records_type' => 'Quarterly Assessment',
            'quarter' => $quarter,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function getNextQuarter($currentQuarter)
    {
        $quarters = ['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter'];
        $currentIndex = array_search($currentQuarter, $quarters);
        return $currentIndex !== false && $currentIndex < count($quarters) - 1 ? $quarters[$currentIndex + 1] : null;
    }

    public function viewClassRecordBySubjectListing(Request $request, $subject_listing)
    {
        $records_name = $request->records_name;
        return view('teacher.view_records', compact('subject_listing', 'request'));
    }

    public function viewReportCardTeacher()
    {
        return view('teacher.report_card');
    }

    public function getAdvisoryStudentsBySchoolYear(Request $request)
    {
        $validatedData = $request->validate([
            'school_year' => 'required|string',
        ]);

        $teacher = Auth::user()->teacher;
        if (!$teacher) {
            return response()->json([
                'valid' => false,
                'msg' => 'Teacher account not found.',
            ], 404);
        }

        try {
            $advisories = Adviser::where('teacher_id', $teacher->teacher_id)
                ->where('school_year', $validatedData['school_year'])
                ->pluck('adviser_id');

            if ($advisories->isEmpty()) {
                return response()->json([
                    'valid' => true,
                    'data' => [],
                    'msg' => 'No advisories found for the specified school year.',
                ]);
            }

            $studentsWithStatuses = StudentStatus::whereIn('adviser_id', $advisories)
                ->with('student')
                ->get();

            $response = $studentsWithStatuses->map(function ($status, $key) {
                $student = $status->student;
                return [
                    'count' => $key + 1,
                    'image' => $student->image && file_exists(public_path($student->image))
                        ? '<img class="img img-fluid img-rounded" alt="Student Avatar" src="' . asset($student->image) . '" style="width: 50px;">'
                        : '<img class="img img-fluid img-rounded" alt="Default Avatar" src="' . asset('images/default-avatar.png') . '" style="width: 50px;">',
                    'student_lrn' => $student->student_lrn,
                    'student_name' => strtoupper(trim($student->first_name . ' ' . ($student->middle_name ?? '') . ' ' . $student->last_name . ' ' . ($student->extension_name ?? ''))),
                    'action' => '<button type="button" onclick="generate(' . "'" . $student->student_lrn . "'" . ')" class="btn btn-md btn-primary" title="Generate Report Card"><i class="fa fa-file"></i></button>',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching advisory students: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve advisory students at the moment. Please try again later.',
            ]);
        }
    }

    //Student Controller

    public function viewDashboardStudent()
    {
        return view('student.dashboard');
    }

    public function viewAttendances()
    {
        // dd(session()->get('username'));
        return view('student.attendances');
    }

    public function viewGrades()
    {
        $user = User::where('user_id', session()->get('user_id'))->firstOrFail();
        $username = $user->username;

        $gradeLevels = DB::table('student_statuses')
            ->where('student_statuses.student_lrn', $username)
            ->get();

        return view('student.grades', compact('gradeLevels'));
    }

    public function viewClassRecordStudent()
    {
        return view('student.classrecords');
    }

    public function getStudentSubject()
    {
        $user = User::where('user_id', session()->get('user_id'))->firstOrFail();
        $username = $user->username;

        $gradeLevels = DB::table('subject_teachers')
            ->join('student_statuses', function ($join) {
                $join->on('subject_teachers.school_year', '=', 'student_statuses.school_year')
                    ->on('subject_teachers.section', '=', 'student_statuses.section')
                    ->on('subject_teachers.grade_level', '=', 'student_statuses.grade_level');
            })
            ->join('subjects', 'subject_teachers.subject_code', 'subjects.subject_code')
            ->join('teachers', 'subject_teachers.teacher_id', 'teachers.teacher_id')
            ->where('student_statuses.student_lrn', $username)
            ->select(
                'subject_teachers.subject_listing',
                'subjects.subject_code',
                'subjects.subject_name',
                DB::raw("CONCAT(
                    teachers.first_name,
                    ' ',
                    COALESCE(teachers.middle_name, ''),
                    ' ',
                    teachers.last_name,
                    ' ',
                    COALESCE(teachers.extension_name, '')
                ) as teacher_name"),
            )
            ->get();

        $response = $gradeLevels->map(function ($list, $index) {
            return [
                'count' => $index + 1,
                'subject_code' => $list->subject_code,
                'subject_name' => $list->subject_name,
                'teacher_name' => $list->teacher_name,
                'action' => '<button class="btn btn-md btn-primary" title="View Records" onclick="view(' . $list->subject_listing . ')"><i class="fa fa-eye"></i></button>'
            ];
        })->toArray();

        return response()->json($response);
    }

    public function viewStudentRecords($subject_listing)
    {
        // Fetch Subject Teacher Details
        $subjectTeacher = DB::table('subject_teachers')
            ->join('teachers', 'teachers.teacher_id', '=', 'subject_teachers.teacher_id')
            ->join('subjects', 'subjects.subject_code', '=', 'subject_teachers.subject_code')
            ->where('subject_teachers.subject_listing', $subject_listing)
            ->select(
                'subject_teachers.subject_listing',
                'subject_teachers.school_year',
                'subject_teachers.grade_level',
                'subject_teachers.section',
                'subjects.subject_code',
                'subjects.subject_name'
            )
            ->first();

        return view('student.view_class_records', compact('subject_listing', 'subjectTeacher'));
    }

    // All User Role Controller

    public function viewProfile()
    {
        // dd(session()->get('username'));
        $role = session()->get('role');
        switch ($role) {
            case "student":
                $student = DB::table('students')
                    ->join('brgys', 'brgys.brgy_code', 'students.brgy_code')
                    ->join('municipalities', 'municipalities.municipality_code', 'brgys.municipality_code')
                    ->join('provinces', 'provinces.province_code', 'brgys.province_code')
                    ->join('regions', 'regions.region_code', 'brgys.region_code')
                    ->where('student_lrn', session('username'))
                    ->first();
                return view("student.profiles", compact('student'));
            case "teacher":
                $teacher = DB::table('teachers')
                    ->join('brgys', 'brgys.brgy_code', 'teachers.brgy_code')
                    ->join('municipalities', 'municipalities.municipality_code', 'brgys.municipality_code')
                    ->join('provinces', 'provinces.province_code', 'brgys.province_code')
                    ->join('regions', 'regions.region_code', 'brgys.region_code')
                    ->where('teacher_id', session('username'))
                    ->first();
                return view("teacher.profiles", compact('teacher'));
            case "principal":
                $principal = DB::table('principals')
                    ->join('brgys', 'brgys.brgy_code', 'principals.brgy_code')
                    ->join('municipalities', 'municipalities.municipality_code', 'brgys.municipality_code')
                    ->join('provinces', 'provinces.province_code', 'brgys.province_code')
                    ->join('regions', 'regions.region_code', 'brgys.region_code')
                    ->where('principal_id', session('username'))
                    ->first();
                return view("principal.profiles", compact('principal'));
            default:
                return view("index");
        }
    }

    //School Year

    public function changeSchoolYear($school_year)
    {
        try {
            // Store the school year in the session
            session()->put('school_year', $school_year);

            // Return a success response
            return response()->json([
                'valid' => true,
                'msg' => 'School year changed successfully.',
                'data' => [
                    'school_year' => session('school_year'),
                ],
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Failed to change school year: ' . $e->getMessage());

            // Return a failure response
            return response()->json([
                'valid' => false,
                'msg' => 'Failed to change school year.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateScore(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'pk' => [
                    'required',
                    'integer',
                    'exists:class_records,records_id' // Ensure the record exists
                ],
                'value' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:100'
                ],
            ], [
                'pk.required' => 'The record ID is required.',
                'pk.integer' => 'The record ID must be a valid integer.',
                'pk.exists' => 'The specified record does not exist.',
                'value.required' => 'The score value is required.',
                'value.numeric' => 'The score value must be a number.',
                'value.min' => 'The score value cannot be less than 0.',
                'value.max' => 'The score value cannot exceed 100.',
            ]);

            // Fetch the record
            $classRecord = ClassRecord::find($validatedData['pk']);

            // Check if total_score is set
            if ($classRecord->total_score === null) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Set the total score first before setting the student score.',
                ], 200);
            }

            if ($validatedData['value'] > $classRecord->total_score) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Invalid score! The score must not be greater than ' . $classRecord->total_score,
                ], 200);
            }

            // Update the student score
            $classRecord->update([
                'student_score' => $validatedData['value'],
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Successfully updated the score.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation Error during score update', [
                'errors' => $e->errors(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'valid' => false,
                'msg' => 'Invalid input data. Please correct the errors and try again.',
                'errors' => $e->errors(),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unexpected Error during score update', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'valid' => false,
                'msg' => 'An unexpected error occurred. Please try again later.',
            ], 200);
        }
    }

    public function updateTotalScore(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'pk' => [
                    'required',
                    'string',
                ],
                'value' => [
                    'required',
                    'numeric',
                    'min:0',
                    'max:100'
                ],
            ], [
                'pk.required' => 'The record ID is required.',
                'pk.string' => 'The record ID must be a valid integer.',
                'value.required' => 'The score value is required.',
                'value.numeric' => 'The score value must be a number.',
                'value.min' => 'The score value cannot be less than 0.',
                'value.max' => 'The score value cannot exceed 100.',
            ]);

            $pkSplit = explode(',', $validatedData['pk']);
            $recordsName = $pkSplit[0];
            $quarter = $pkSplit[1];

            // Fetch the record
            $classRecord = ClassRecord::where('records_name', $recordsName)
                ->where('quarter', $quarter)
                ->update([
                    'total_score' => $validatedData['value'],
                ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Successfully updated the total score.',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation Error during score update', [
                'errors' => $e->errors(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'valid' => false,
                'msg' => 'Invalid input data. Please correct the errors and try again.',
                'errors' => $e->errors(),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unexpected Error during score update', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'valid' => false,
                'msg' => 'An unexpected error occurred. Please try again later.',
            ], 200);
        }
    }
}
