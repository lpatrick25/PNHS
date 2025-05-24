<?php

namespace App\Http\Controllers;

use App\Models\ClassRecord;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ClassRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch class records with related student data
            $classRecords = DB::table('class_records')
                ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
                ->where('class_records.school_year', session('school_year'))
                ->select(
                    DB::raw("CONCAT(
                    students.last_name,
                    ', ',
                    students.first_name,
                    ' ',
                    COALESCE(students.middle_name, '')
                ) as name"),
                    'class_records.records_id',
                    'class_records.records_name',
                    'class_records.records_type',
                    'class_records.student_score',
                    'class_records.total_score',
                    'class_records.quarter',
                )
                ->orderBy('students.last_name', 'asc') // Order by student last name
                ->get();

            // Organize data by students and scores
            $score = [
                'writtenWorks' => array_fill(0, 10, ['score' => null, 'records_id' => null]),
                'performanceTasks' => array_fill(0, 10, ['score' => null, 'records_id' => null]),
                'quarterlyAssessment' => ['score' => null, 'records_id' => null],
            ];
            $students = [];

            foreach ($classRecords as $record) {
                $studentName = $record->name;
                $recordsID = $record->records_id;
                $recordType = $record->records_type;

                if (!isset($students[$studentName])) {
                    $students[$studentName] = [
                        'name' => $studentName,
                        'records_id' => $recordsID,
                        'writtenWorks' => array_fill(0, 10, null), // Placeholder for scores
                        'performanceTasks' => array_fill(0, 10, null),
                        'quarterlyAssessment' => null,
                    ];
                }

                if (strpos($record->records_name, 'Written Works') !== false) {
                    $index = intval(str_replace('Written Works ', '', $record->records_name)) - 1;
                    if ($index >= 0 && $index < 10) { // Validate index bounds
                        $students[$studentName]['writtenWorks'][$index] = $record->student_score;
                        $score['writtenWorks'][$index] = [
                            'score' => $record->total_score,
                            'records_id' => $recordsID,
                        ];
                    }
                } elseif (strpos($record->records_name, 'Performance Tasks') !== false) {
                    $index = intval(str_replace('Performance Tasks ', '', $record->records_name)) - 1;
                    if ($index >= 0 && $index < 10) { // Validate index bounds
                        $students[$studentName]['performanceTasks'][$index] = $record->student_score;
                        $score['performanceTasks'][$index] = [
                            'score' => $record->total_score,
                            'records_id' => $recordsID,
                        ];
                    }
                } elseif ($recordType === 'Quarterly Assessment') {
                    $students[$studentName]['quarterlyAssessment'] = $record->student_score;
                    $score['quarterlyAssessment'] = [
                        'score' => $record->total_score,
                        'records_id' => $recordsID,
                    ];
                }
            }

            // Combine the students and scores into a single array for the response
            return response()->json([
                'students' => array_values($students),
                'scores' => $score,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching class records: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to retrieve the class records. Please try again later.',
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
                'records_type' => 'required|string',
                'total_score' => 'required|integer|min:1',
                'quarter' => 'required|string',
                'subject_listing' => 'required|exists:subject_teachers,subject_listing',
            ]);

            // Retrieve the subject teacher details
            $subjectTeacher = SubjectTeacher::where('subject_listing', $validated['subject_listing'])->firstOrFail();

            // Get the list of students
            $students = DB::table('student_statuses')
                ->join('students', 'students.student_lrn', '=', 'student_statuses.student_lrn')
                ->where('student_statuses.grade_level', $subjectTeacher->grade_level)
                ->where('student_statuses.section', $subjectTeacher->section)
                ->where('student_statuses.school_year', $subjectTeacher->school_year)
                ->select('students.student_lrn', 'student_statuses.school_year')
                ->get();

            if ($students->isEmpty()) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No students found for the specified subject listing.',
                ]);
            }

            // Determine the record name and validation based on records_type and quarter
            $recordsName = '';
            $assessmentExistsInPreviousQuarter = false;

            switch ($validated['records_type']) {
                case 'Written Works':
                    // Fetch existing record names that match "Written Works "
                    $writtenWorks = DB::table('class_records')
                        ->selectRaw('DISTINCT records_name') // Use selectRaw for DISTINCT
                        ->where('records_name', 'LIKE', 'Written Works %') // No need for table alias here
                        ->where('quarter', $validated['quarter'])
                        ->get();

                    $nextNumber = $writtenWorks->count() + 1; // Use the count method on the collection

                    // Generate the new record name
                    $recordsName = 'Written Works ' . $nextNumber;

                    // Ensure there's a maximum of 10 written works
                    if ($nextNumber > 10) {
                        return response()->json([
                            'valid' => false,
                            'msg' => 'Maximum number of Written Works reached.',
                        ]);
                    }

                    // Validate if assessment exists in the previous quarter
                    if ($validated['quarter'] !== '1st Quarter') {
                        $assessmentExistsInPreviousQuarter = ClassRecord::where('records_type', 'Quarterly Assessment')
                            ->where('quarter', $this->getPreviousQuarter($validated['quarter']))
                            ->exists();
                        if (!$assessmentExistsInPreviousQuarter) {
                            return response()->json([
                                'valid' => false,
                                'msg' => 'Cannot add Written Works in this quarter without an assessment in the previous quarter.',
                            ]);
                        }
                    }
                    break;

                case 'Performance Tasks':
                    // Fetch existing record names that match "Performance Tasks "
                    $performanceTasks = DB::table('class_records')
                        ->selectRaw('DISTINCT records_name') // Use selectRaw for DISTINCT
                        ->where('records_name', 'LIKE', 'Performance Tasks %') // No need for table alias here
                        ->where('quarter', $validated['quarter'])
                        ->get();

                    $nextNumber = $performanceTasks->count() + 1; // Use the count method on the collection

                    // Generate the new record name
                    $recordsName = 'Performance Tasks ' . $nextNumber;

                    // Ensure there's a maximum of 10 performance tasks
                    if ($nextNumber > 10) {
                        return response()->json([
                            'valid' => false,
                            'msg' => 'Maximum number of Performance Tasks reached.',
                        ]);
                    }

                    // Validate if assessment exists in the previous quarter
                    if ($validated['quarter'] !== '1st Quarter') {
                        $assessmentExistsInPreviousQuarter = ClassRecord::where('records_type', 'Quarterly Assessment')
                            ->where('quarter', $this->getPreviousQuarter($validated['quarter']))
                            ->exists();
                        if (!$assessmentExistsInPreviousQuarter) {
                            return response()->json([
                                'valid' => false,
                                'msg' => 'Cannot add Performance Tasks in this quarter without an assessment in the previous quarter.',
                            ]);
                        }
                    }
                    break;

                case 'Quarterly Assessment':
                    // Check if there is already a Quarterly Assessment for the given quarter
                    $existingRecord = ClassRecord::where('records_type', 'Quarterly Assessment')
                        ->where('subject_listing', $validated['subject_listing'])
                        ->where('quarter', $validated['quarter'])
                        ->count();

                    if ($existingRecord > 0) {
                        return response()->json([
                            'valid' => false,
                            'msg' => 'A Quarterly Assessment already exists for this quarter.',
                        ]);
                    }

                    // Generate the record name for Quarterly Assessment
                    $recordsName = $validated['quarter'] . ' Assessment';
                    break;

                default:
                    return response()->json([
                        'valid' => false,
                        'msg' => 'Invalid record type provided.',
                    ]);
            }

            // Prepare data for bulk insert
            $classRecordsData = $students->map(function ($student) use ($validated, $recordsName) {
                return [
                    'records_type' => $validated['records_type'],
                    'total_score' => $validated['total_score'],
                    'quarter' => $validated['quarter'],
                    'subject_listing' => $validated['subject_listing'],
                    'student_lrn' => $student->student_lrn,
                    'school_year' => $student->school_year,
                    'records_name' => $recordsName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            // Bulk insert class records
            ClassRecord::insert($classRecordsData);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Class records added successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding class records: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to create the class records. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $selectedQuarter)
    {
        try {
            // Fetch class records with related student data
            $classRecordsQuery = DB::table('class_records')
                ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
                ->where('class_records.school_year', session('school_year'))
                ->where('class_records.quarter', $selectedQuarter)
                ->select(
                    DB::raw("CONCAT(
                    students.last_name,
                    ', ',
                    students.first_name,
                    ' ',
                    COALESCE(students.middle_name, '')
                ) as name"),
                    'class_records.records_id',
                    'class_records.records_name',
                    'class_records.records_type',
                    'class_records.student_score',
                    'class_records.total_score',
                    'class_records.quarter',
                )
                ->orderBy('students.last_name', 'asc');

            // Organize data by students and scores
            $score = [
                'writtenWorks' => array_fill(0, 10, ['score' => null, 'records_id' => null]),
                'performanceTasks' => array_fill(0, 10, ['score' => null, 'records_id' => null]),
                'quarterlyAssessment' => ['score' => null, 'records_id' => null],
            ];
            $students = [];

            if (session()->get('role') === 'student') {
                $classRecords = $classRecordsQuery->where('class_records.student_lrn', session()->get('username'))->get();
            } else {
                $classRecords = $classRecordsQuery->get();
            }

            foreach ($classRecords as $record) {
                $quarter = $record->quarter;
                $studentName = $record->name;
                $recordsID = $record->records_id;
                $recordType = $record->records_type;

                if (!isset($students[$studentName])) {
                    $students[$studentName] = [
                        'name' => $studentName,
                        'writtenWorksRecordsID' => array_fill(0, 10, null), // Placeholder for scores
                        'performanceTasksRecordsID' => array_fill(0, 10, null), // Placeholder for scores
                        'writtenWorks' => array_fill(0, 10, null), // Placeholder for scores
                        'performanceTasks' => array_fill(0, 10, null),
                        'quarterlyAssessment' => null,
                        'quarterlyAssessmentRecordsID' => null,
                    ];
                }

                if (strpos($record->records_name, 'Written Works') !== false) {
                    $index = intval(str_replace('Written Works ', '', $record->records_name)) - 1;
                    if ($index >= 0 && $index < 10) { // Validate index bounds
                        $students[$studentName]['writtenWorks'][$index] = $record->student_score;
                        $students[$studentName]['writtenWorksRecordsID'][$index] = $recordsID;
                        $score['writtenWorks'][$index] = [
                            'score' => $record->total_score,
                            'records_id' => $recordsID,
                            'quarter' => $quarter,
                        ];
                    }
                } elseif (strpos($record->records_name, 'Performance Tasks') !== false) {
                    $index = intval(str_replace('Performance Tasks ', '', $record->records_name)) - 1;
                    if ($index >= 0 && $index < 10) { // Validate index bounds
                        $students[$studentName]['performanceTasks'][$index] = $record->student_score;
                        $students[$studentName]['performanceTasksRecordsID'][$index] = $recordsID;
                        $score['performanceTasks'][$index] = [
                            'score' => $record->total_score,
                            'records_id' => $recordsID,
                            'quarter' => $quarter,
                        ];
                    }
                } elseif ($recordType === 'Quarterly Assessment') {
                    $students[$studentName]['quarterlyAssessment'] = $record->student_score;
                    $students[$studentName]['quarterlyAssessmentRecordsID'] = $recordsID;
                    $score['quarterlyAssessment'] = [
                        'score' => $record->total_score,
                        'records_id' => $recordsID,
                        'quarter' => $quarter,
                    ];
                }
            }

            // Combine the students and scores into a single array for the response
            return response()->json([
                'students' => array_values($students),
                'scores' => $score,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching class records: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to retrieve the class records. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $records_id)
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'student_score' => 'required|numeric|min:0',
            ]);

            // Retrieve class record by records_id
            $classRecord = ClassRecord::where('records_id', $records_id)->first();

            if (!$classRecord) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Class record not found. Please try again later.',
                ], 200); // Return 404 not found if record doesn't exist
            }

            // Check if the provided score is valid (should not exceed total score)
            if ($request->student_score > $classRecord->total_score) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Provided score exceeds the total score.',
                ], 200); // Return 400 bad request for invalid score
            }

            // Update the class record with the new student score
            $classRecord->student_score = $request->student_score;
            $classRecord->save(); // Use save() for the update to ensure proper model event handling

            return response()->json([
                'valid' => true,
                'msg' => 'Student score updated successfully.',
                'data' => $classRecord,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'valid' => false,
                'msg' => 'Invalid input data: ' . $e->getMessage(),
            ], 422); // Return 422 Unprocessable Entity for validation errors
        } catch (\Exception $e) {
            // Log any unexpected exceptions
            Log::error('Error updating student score: ' . $e->getMessage(), [
                'records_id' => $records_id,
                'request' => $request->all(),
            ]);

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to update student score at the moment. Please try again later.',
            ], 500); // Return 500 Internal Server Error for generic errors
        }
    }

    public function getClassRecordsByTeacher($teacher_id)
    {
        try {
            $subjectTeacher = DB::table('subject_teachers')
                ->join('subjects', 'subjects.subject_code', '=', 'subject_teachers.subject_code')
                ->join('advisers', function ($join) {
                    $join->on('advisers.grade_level', '=', 'subject_teachers.grade_level')
                        ->on('advisers.section', '=', 'subject_teachers.section')
                        ->where('advisers.school_year', '=', session('school_year'));
                })
                ->join('teachers as adviser_teachers', 'advisers.teacher_id', '=', 'adviser_teachers.teacher_id') // Join the teachers table for adviser's details
                ->where('subject_teachers.school_year', session('school_year'))
                ->where('subject_teachers.teacher_id', $teacher_id)
                ->select(
                    'subject_teachers.subject_listing',
                    'subject_teachers.school_year',
                    'subject_teachers.grade_level',
                    'subject_teachers.section',
                    'subjects.subject_code',
                    'subjects.subject_name',
                    'advisers.teacher_id as adviser_teacher_id',
                    'advisers.section as adviser_section',
                    DB::raw("CONCAT(
                            adviser_teachers.first_name,
                            ' ',
                            COALESCE(CONCAT(LEFT(adviser_teachers.middle_name, 1), '.'), ''),
                            ' ',
                            adviser_teachers.last_name
                        ) as adviser_name")
                )
                ->get();

            $response = $subjectTeacher->map(function ($list, $key) {
                return [
                    'count' => $key + 1,
                    'subject' => $list->subject_code . ' - ' . $list->subject_name,
                    'grade_level_section' => '<span class="text-success" style="font-weight: bolder;">Grade ' . $list->grade_level . '</span> - <span class="text-danger" style="font-weight: bolder;">' . $list->section . '</span>',
                    'school_year' => $list->school_year,
                    'adviser_name' => $list->adviser_name,
                    'action' => '<button type="button" class="btn btn-md btn-primary" title="View Class Records" onclick="view(\'' . addslashes($list->subject_listing) . '\')"><i class="fa fa-eye"></i></button>',
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

    public function viewClassRecords(Request $request, $records_name)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'quarter' => 'required',
                'subject_listing' => 'required|exists:subject_teachers,subject_listing',
            ]);

            $quarter = $validated['quarter'];
            $subject_listing = $validated['subject_listing'];

            // Fetch student data with the specified records_name and subject_listing
            $students = DB::table('class_records')
                ->join('students', 'students.student_lrn', '=', 'class_records.student_lrn')
                ->where('class_records.subject_listing', $subject_listing)
                ->where('class_records.records_name', '=', $records_name)
                ->where('class_records.quarter', $quarter)
                ->select(
                    'students.student_lrn',
                    'students.image',
                    'class_records.records_id',
                    'class_records.total_score',
                    'class_records.student_score',
                    DB::raw("CONCAT(
                        students.first_name,
                        ' ',
                        COALESCE(CONCAT(LEFT(students.middle_name, 1), '.'), ''),
                        ' ',
                        students.last_name
                    ) as student_name")
                )
                ->get();

            // Check if no students are found
            if ($students->isEmpty()) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No students found for the specified subject listing and record name.',
                ]);
            }

            // Transform the student data for the response
            $response = $students->map(function ($student, $index) {
                $imageUrl = $student->image ? asset($student->image) : asset('default-avatar.png');
                $actionButton = $student->student_score === null
                    ? '<button class="btn btn-primary btn-md" onclick="addScore(' . htmlspecialchars($student->records_id) . ')"><i class="fa fa-plus-circle"></i> Add Score</button>'
                    : '<button class="btn btn-success btn-md" onclick="updateScore(' . htmlspecialchars($student->records_id) . ', ' . htmlspecialchars($student->student_score) . ')"><i class="fa fa-edit"></i> ' . htmlspecialchars($student->student_score) . '/' . htmlspecialchars($student->total_score) . '</button>';
                return [
                    'count' => $index + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . $imageUrl . '" style="width: 50px;">',
                    'student_lrn' => '<span class="text-danger" style="font-weight: bolder;">' . $student->student_lrn . '</span>',
                    'student_name' => '<span class="text-danger" style="font-weight: bolder;">' . $student->student_name . '</span>',
                    'action' => $actionButton,
                ];
            });

            // Return the transformed data as JSON
            return response()->json([
                'valid' => true,
                'data' => $response->toArray(),
            ]);
        } catch (\Exception $e) {
            // Log and handle any errors
            Log::error('Error fetching class records: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve class records at the moment. Please try again later.',
            ]);
        }
    }

    public function exportToExcel($subject_listing)
    {
        try {
            // Fetch class records
            $classRecords = DB::table('class_records')
                ->join('subject_teachers', 'class_records.subject_listing', '=', 'subject_teachers.subject_listing')
                ->join('teachers', 'subject_teachers.teacher_id', '=', 'teachers.teacher_id')
                ->join('subjects', 'subject_teachers.subject_code', '=', 'subjects.subject_code')
                ->where('class_records.subject_listing', $subject_listing)
                ->select(
                    'subjects.subject_code',
                    'subjects.subject_name',
                    'subject_teachers.grade_level',
                    'subject_teachers.section',
                    'subject_teachers.school_year',
                    'teachers.last_name',
                    'teachers.first_name',
                    'teachers.middle_name',
                    'teachers.extension_name',
                    'class_records.quarter',
                )
                ->first();

            // Check if records are empty
            if (!$classRecords) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No records found for the specified subject listing.',
                ]);
            }

            $filePath = public_path('classrecord/ClassRecord.xls');

            if (!file_exists($filePath)) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Template file not found.',
                ]);
            }

            // Load the existing spreadsheet
            $spreadsheet = IOFactory::load($filePath);

            $fullName = $this->formatFullName(
                $classRecords->first_name,
                $classRecords->middle_name,
                $classRecords->last_name,
                $classRecords->extension_name
            );

            $sheet = $spreadsheet->getSheetByName('INPUT DATA');

            $sheet->setCellValue('G4', strtoupper('REGION-VII'));
            $sheet->setCellValue('O4', strtoupper('LEYTE'));
            $sheet->setCellValue('X5', strtoupper('303414'));
            $sheet->setCellValue('G5', strtoupper('PALALE NATIONAL HIGH SCHOOL'));
            $sheet->setCellValue('K7', strtoupper($classRecords->grade_level . '-' . $classRecords->section));
            $sheet->setCellValue('S7', strtoupper($fullName));
            $sheet->setCellValue('AG7', strtoupper($classRecords->subject_name));
            $sheet->setCellValue('AG5', strtoupper($classRecords->school_year));

            //
            $sheet = $spreadsheet->getSheetByName('SUMMARY OF QUARTERLY GRADES');
            $sheet->setCellValue('F10', strtoupper(''));
            $sheet->setCellValue('J10', strtoupper(''));
            $sheet->setCellValue('N10', strtoupper(''));
            $sheet->setCellValue('R10', strtoupper(''));


            $maleNames = [];
            $femaleNames = [];
            $nameRow = [];

            $this->writeToExcelRecordsTypeScore($spreadsheet, $subject_listing);
            $this->writeToExcelStudentName($spreadsheet, $subject_listing, $maleNames, $femaleNames, $nameRow);
            $this->writeToExcelStudentScore($spreadsheet, $subject_listing, $nameRow);

            // Create directory based on instructor_id if it doesn't exist
            $directoryPath = public_path("classrecord/{$subject_listing}");
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }

            $fileName = '(' . $classRecords->school_year . ')' . strtoupper(str_replace(' ', '_', $classRecords->last_name)) . '-Grade' . $classRecords->grade_level . '-' . $classRecords->section . '-' . $classRecords->subject_name;

            // Save the updated file in the new directory
            $newFilePath = "{$directoryPath}/{$fileName}.xlsx";
            $writer = new Xlsx($spreadsheet);
            $writer->save($newFilePath);

            $downloadUrl = route('downloadExcel', ['subject_listing' => $subject_listing, 'fileName' => "{$fileName}.xlsx"]);
            $download = '<a href="' . $downloadUrl . '" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>';

            return response()->json([
                'valid' => true,
                'msg' => 'Class records exported successfully.',
                'file_path' => $newFilePath,
                'download' => $download,
            ]);
        } catch (\Exception $e) {
            Log::error('Error during export: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while exporting class records.',
            ]);
        }
    }

    public function writeToExcelStudentName($spreadsheet, $subject_listing, &$maleNames, &$femaleNames, &$nameRow)
    {
        try {
            $classRecords = DB::table('class_records')
                ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
                ->where('class_records.subject_listing', $subject_listing)
                ->select(
                    'students.student_lrn',
                    'students.sex',
                    DB::raw("CONCAT(
                    students.last_name,
                    ', ',
                    students.first_name,
                    ' ',
                    COALESCE(students.middle_name, '')
                ) as student_name")
                )
                ->orderBy('student_name', 'asc')
                ->get()
                ->unique('student_lrn'); // Remove duplicates based on student_lrn

            $maleCell = '12';
            $femaleCell = '63';

            foreach ($classRecords as $classRecord) {
                $sheet = $spreadsheet->getSheetByName('INPUT DATA');

                if ($classRecord->sex === "Male") {
                    if (!in_array($classRecord->student_name, $maleNames)) {
                        $cell = 'B' . $maleCell;
                        $sheet->setCellValue($cell, strtoupper($classRecord->student_name));
                        $maleNames[] = $classRecord->student_name;
                        $nameRow[$classRecord->student_name] = $maleCell;
                        $maleCell++;
                    }
                } elseif ($classRecord->sex === "Female") {
                    if (!in_array($classRecord->student_name, $femaleNames)) {
                        $cell = 'B' . $femaleCell;
                        $sheet->setCellValue($cell, strtoupper($classRecord->student_name));
                        $femaleNames[] = $classRecord->student_name;
                        $nameRow[$classRecord->student_name] = $femaleCell;
                        $femaleCell++;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error during export: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while exporting class records.',
            ]);
        }
    }

    public function writeToExcelRecordsTypeScore($spreadsheet, $subject_listing)
    {
        try {
            // Fetch class records grouped by quarter
            $classRecords = DB::table('class_records')
                ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
                ->where('class_records.subject_listing', $subject_listing)
                ->select(
                    'class_records.total_score',
                    'class_records.quarter',
                    'class_records.records_type',
                    'class_records.records_name',
                    DB::raw("CONCAT(
                        students.last_name,
                        ', ',
                        students.first_name,
                        ' ',
                        COALESCE(students.middle_name, '')
                    ) as student_name")
                )
                ->orderByRaw("FIELD(class_records.records_type, 'Written Works', 'Performance Tasks', 'Quarterly Assessment')")
                ->orderBy('student_name', 'asc')
                ->get()
                ->groupBy('quarter');

            // Map quarter names to sheet names
            $quarterToSheetMap = [
                "1st Quarter" => 'Q1',
                "2nd Quarter" => 'Q2',
                "3rd Quarter" => 'Q3',
                "4th Quarter" => 'Q4',
            ];

            foreach ($quarterToSheetMap as $quarter => $sheetName) {
                if ($classRecords->has($quarter)) {
                    $this->writeToExcelRecordsTypeScoreByQuarter($classRecords->get($quarter), $spreadsheet, $sheetName);
                } else {
                    Log::info("No records found for $quarter.");
                }
            }
        } catch (\Exception $e) {
            Log::error('Error during export: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while exporting class records.',
            ]);
        }
    }

    public function writeToExcelRecordsTypeScoreByQuarter($classRecords, $spreadsheet, $sheetName)
    {
        try {
            // Define cell ranges
            $writtenWorksCells = ['F10', 'G10', 'H10', 'I10', 'J10', 'K10', 'L10', 'M10', 'N10', 'O10'];
            $performanceTasksCells = ['S10', 'T10', 'U10', 'V10', 'W10', 'X10', 'Y10', 'Z10', 'AA10', 'AB10'];
            $assessmentCell = 'AF10';

            $sheet = $spreadsheet->getSheetByName($sheetName);

            if (!$sheet) {
                Log::warning("Sheet not found: $sheetName");
                return;
            }

            $writtenWorksIndex = 0;
            $performanceTasksIndex = 0;

            foreach ($classRecords as $record) {
                switch ($record->records_type) {
                    case 'Written Works':
                        if (isset($writtenWorksCells[$writtenWorksIndex])) {
                            $sheet->setCellValue($writtenWorksCells[$writtenWorksIndex], $record->total_score);
                            $writtenWorksIndex++;
                        }
                        break;

                    case 'Performance Tasks':
                        if (isset($performanceTasksCells[$performanceTasksIndex])) {
                            $sheet->setCellValue($performanceTasksCells[$performanceTasksIndex], $record->total_score);
                            $performanceTasksIndex++;
                        }
                        break;

                    case 'Quarterly Assessment':
                        $sheet->setCellValue($assessmentCell, $record->total_score);
                        break;

                    default:
                        Log::warning("Unknown records_type: {$record->records_type} in $sheetName");
                }
            }
        } catch (\Exception $e) {
            Log::error("Error writing data to $sheetName: " . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => "An error occurred while exporting data to $sheetName.",
            ]);
        }
    }

    public function writeToExcelStudentScore($spreadsheet, $subject_listing, $nameRow)
    {
        try {
            // Fetch class records grouped by quarter
            $classRecords = DB::table('class_records')
                ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
                ->where('class_records.subject_listing', $subject_listing)
                ->select(
                    'class_records.quarter',
                    'class_records.records_type',
                    'class_records.student_score',
                    DB::raw("CONCAT(
                    students.last_name,
                    ', ',
                    students.first_name,
                    ' ',
                    COALESCE(students.middle_name, '')
                ) as student_name")
                )
                ->orderByRaw("FIELD(class_records.records_type, 'Written Works', 'Performance Tasks', 'Quarterly Assessment')")
                ->orderBy('student_name', 'asc')
                ->get()
                ->groupBy('quarter');

            // Map quarter names to match grouped keys
            $quarterKeys = [
                "1st Quarter" => 'Q1',
                "2nd Quarter" => 'Q2',
                "3rd Quarter" => 'Q3',
                "4th Quarter" => 'Q4',
            ];

            // Iterate through each quarter and write data to Excel
            foreach ($quarterKeys as $quarterName => $sheetName) {
                if ($classRecords->has($quarterName)) {
                    $this->writeToExcelStudentScoreByQuarter($classRecords->get($quarterName), $spreadsheet, $nameRow);
                } else {
                    Log::info("No records found for $quarterName.");
                }
            }
        } catch (\Exception $e) {
            Log::error('Error during export: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while exporting class records.',
            ]);
        }
    }

    public function writeToExcelStudentScoreByQuarter($classRecords, $spreadsheet, $nameRow)
    {
        try {
            $tempName = '';
            $writtenWorksCol = '';
            $performanceTasksCol = '';

            foreach ($classRecords as $classRecord) {
                // Determine the correct sheet by quarter
                $sheet = match ($classRecord->quarter) {
                    "1st Quarter" => $spreadsheet->getSheetByName('Q1'),
                    "2nd Quarter" => $spreadsheet->getSheetByName('Q2'),
                    "3rd Quarter" => $spreadsheet->getSheetByName('Q3'),
                    "4th Quarter" => $spreadsheet->getSheetByName('Q4'),
                    default => null,
                };

                if (!$sheet) {
                    Log::warning("Sheet not found for quarter: {$classRecord->quarter}");
                    continue;
                }

                // Reset column pointers if new student
                if ($tempName !== $classRecord->student_name) {
                    $writtenWorksCol = 'F';
                    $performanceTasksCol = 'S';
                    $tempName = $classRecord->student_name;
                }

                // Write scores based on record type
                if ($classRecord->records_type === "Written Works") {
                    if ($classRecord->student_score === 0) {
                        continue;
                    }
                    $sheet->setCellValue($writtenWorksCol . $nameRow[$classRecord->student_name], $classRecord->student_score);
                    $writtenWorksCol++;
                }

                if ($classRecord->records_type === "Performance Tasks") {
                    if ($classRecord->student_score === 0) {
                        continue;
                    }
                    $sheet->setCellValue($performanceTasksCol . $nameRow[$classRecord->student_name], $classRecord->student_score);
                    $performanceTasksCol++;
                }

                if ($classRecord->records_type === "Quarterly Assessment") {
                    if ($classRecord->student_score === 0) {
                        continue;
                    }
                    $sheet->setCellValue('AF' . $nameRow[$classRecord->student_name], $classRecord->student_score);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error during export by quarter: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while exporting data for a specific quarter.',
            ]);
        }
    }

    public function downloadExcel($subject_listing, $fileName)
    {
        $filePath = public_path("classrecord/{$subject_listing}/{$fileName}");

        // Check if the file exists
        if (!File::exists($filePath)) {
            abort(404, 'File not found');
        }

        // Download the file
        return response()->download($filePath, $fileName);
    }

    /**
     * Helper method to get the previous quarter
     *
     * @param string $currentQuarter
     * @return string
     */
    private function getPreviousQuarter($currentQuarter)
    {
        $quarters = [
            '1st Quarter' => null,   // No previous quarter
            '2nd Quarter' => '1st Quarter',
            '3rd Quarter' => '2nd Quarter',
            '4th Quarter' => '3rd Quarter',
        ];

        return $quarters[$currentQuarter] ?? null;
    }

    /**
     * Format the full name with proper handling of the middle name.
     *
     * @param string $firstName
     * @param string|null $middleName
     * @param string $lastName
     * @param string|null $extensionName
     * @return string
     */
    private function formatFullName($firstName, $middleName, $lastName, $extensionName)
    {
        $middleInitial = $middleName ? strtoupper(substr($middleName, 0, 1)) . '.' : '';
        $fullName = trim("{$firstName} {$middleInitial} {$lastName} {$extensionName}");
        return $fullName;
    }
}
