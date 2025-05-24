<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function PHPUnit\Framework\isEmpty;

class ReportCardController extends Controller
{
    public function store(Request $request)
    {
        try {
            $student_lrn = $request->student_lrn;
            $school_year = $request->school_year;

            // Fetch class records for the student
            $studentClassRecords = DB::table('class_records')
                ->join('subject_teachers', 'class_records.subject_listing', '=', 'subject_teachers.subject_listing')
                ->join('teachers', 'subject_teachers.teacher_id', '=', 'teachers.teacher_id')
                ->join('subjects', 'subject_teachers.subject_code', '=', 'subjects.subject_code')
                ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
                ->where('class_records.student_lrn', $student_lrn)
                ->where('class_records.school_year', $school_year)
                ->select(
                    'subjects.subject_code',
                    'subjects.subject_name',
                    'subject_teachers.grade_level',
                    'subject_teachers.section',
                    'subject_teachers.school_year',
                    'class_records.subject_listing',
                    'teachers.last_name',
                    'teachers.first_name',
                    'teachers.middle_name',
                    'teachers.extension_name',
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
                ->distinct()
                ->get();

            // Check if records are empty
            if ($studentClassRecords->isEmpty()) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No records found for the specified student LRN.',
                ]);
            }

            // dd($studentClassRecords);

            $subjectGrades = [];

            foreach ($studentClassRecords as $studentRecords) {
                $folderDIR = $studentRecords->subject_listing;
                $fileName = '(' . $studentRecords->school_year . ')' . strtoupper(str_replace(' ', '_', $studentRecords->last_name)) . '-Grade' . $studentRecords->grade_level . '-' . $studentRecords->section . '-' . $studentRecords->subject_name . '.xlsx';
                $filePath = public_path("classrecord/{$folderDIR}/{$fileName}");

                if (!file_exists($filePath)) {
                    Log::warning("File not found: {$filePath}");
                    continue;
                }

                // Load the copied .xls file
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getSheetByName('SUMMARY OF QUARTERLY GRADES');

                if (!$sheet) {
                    Log::warning("Sheet not found: 'SUMMARY OF QUARTERLY GRADES'");
                    continue;
                }

                $subjectName = $sheet->getCell('W9')->getCalculatedValue(); // Retrieve subject name

                $startRow = ($studentRecords->sex === "Male") ? 13 : 64;
                $endRow = ($studentRecords->sex === "Male") ? 62 : 113;

                for ($i = $startRow; $i <= $endRow; $i++) {
                    $studentNameFromSheet = trim($sheet->getCell("B{$i}")->getCalculatedValue());
                    $subject1stQuarterGrade = $sheet->getCell("F{$i}")->getCalculatedValue();
                    $subject2ndQuarterGrade = $sheet->getCell("J{$i}")->getCalculatedValue();
                    $subject3rdQuarterGrade = $sheet->getCell("N{$i}")->getCalculatedValue();
                    $subject4thQuarterGrade = $sheet->getCell("R{$i}")->getCalculatedValue();
                    $subjectFinalGrade = $sheet->getCell("V{$i}")->getCalculatedValue();
                    $remarks = $sheet->getCell("Z{$i}")->getCalculatedValue();

                    if (trim(strtolower($studentNameFromSheet)) === trim(strtolower($studentRecords->student_name))) {
                        $subjectGrades[] = [
                            'subject_name' => $subjectName,
                            '1st_quarter' => $subject1stQuarterGrade,
                            '2nd_quarter' => $subject2ndQuarterGrade,
                            '3rd_quarter' => $subject3rdQuarterGrade,
                            '4th_quarter' => $subject4thQuarterGrade,
                            'final_grade' => $subjectFinalGrade,
                            'remarks' => $remarks,
                        ];
                        break;
                    }
                }
            }

            // Fetch class records
            $studentInfo = DB::table('student_statuses')
                ->join('students', 'student_statuses.student_lrn', '=', 'students.student_lrn')
                ->join('advisers', 'student_statuses.adviser_id', '=', 'advisers.adviser_id')
                ->join('teachers', 'advisers.teacher_id', '=', 'teachers.teacher_id')
                ->where('student_statuses.student_lrn', $student_lrn)
                ->where('student_statuses.school_year', $school_year)
                ->select(
                    'student_statuses.grade_level',
                    'student_statuses.section',
                    'student_statuses.school_year',
                    'students.student_lrn',
                    'students.sex',
                    'students.birthday',
                    DB::raw("CONCAT(
                        students.last_name,
                        ', ',
                        students.first_name,
                        ' ',
                        COALESCE(students.middle_name, '')
                    ) as student_name"),
                    DB::raw("CONCAT(
                        teachers.last_name,
                        ', ',
                        teachers.first_name,
                        ' ',
                        COALESCE(teachers.middle_name, '')
                    ) as teacher_name")
                )
                ->first();

            $filePath = public_path('reportcard/REPORT_CARD.xlsx');

            if (!file_exists($filePath)) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Template file not found.',
                ]);
            }

            // Load the existing spreadsheet
            $spreadsheet = IOFactory::load($filePath);

            $sheet = $spreadsheet->getSheetByName('Front');

            if (!$sheet) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Sheet "Front" not found in the template.',
                ]);
            }

            $studentName = $studentInfo->student_name;
            $studentLRN = $studentInfo->student_lrn;
            $birthday = $studentInfo->birthday;
            $sex = $studentInfo->sex;
            $gradeLevel = $studentInfo->grade_level;
            $section = $studentInfo->section;
            $schoolYear = $studentInfo->school_year;
            $teacherName = $studentInfo->teacher_name;

            if ($birthday) {
                // Calculate the age
                $age = Carbon::parse($birthday)->age;
            } else {
                Log::warning('Birthday is not set or invalid for the student.');
            }

            $sheet->setCellValue('P12', strtoupper($studentName));
            $sheet->setCellValue('W13', strtoupper($studentLRN));
            $sheet->setCellValue('P13', strtoupper($age));
            $sheet->setCellValue('T13', strtoupper($sex));
            $sheet->setCellValue('Q14', strtoupper($gradeLevel));
            $sheet->setCellValue('U14', strtoupper($section));
            $sheet->setCellValue('R15', strtoupper($schoolYear));
            $sheet->setCellValue('U22', strtoupper($teacherName));
            $sheet->setCellValue('U32', strtoupper($teacherName));

            $sheet = $spreadsheet->getSheetByName('Back');

            foreach ($subjectGrades as $grades) {
                if (strcasecmp($grades['subject_name'], "Filipino") === 0) {
                    $sheet->setCellValue('B5', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C5', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D5', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E5', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F5', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G5', strtoupper($grades['remarks']));
                }
                if (strcasecmp($grades['subject_name'], "English") === 0) {
                    $sheet->setCellValue('B7', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C7', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D7', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E7', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F7', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G7', strtoupper($grades['remarks']));
                }
                if (strcasecmp($grades['subject_name'], "Mathematics") === 0) {
                    $sheet->setCellValue('B9', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C9', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D9', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E9', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F9', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G9', strtoupper($grades['remarks']));
                }
                if (strcasecmp($grades['subject_name'], "Science") === 0) {
                    $sheet->setCellValue('B11', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C11', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D11', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E11', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F11', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G11', strtoupper($grades['remarks']));
                }
                if (strcasecmp($grades['subject_name'], "Araling Panlipunan") === 0) {
                    $sheet->setCellValue('B13', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C13', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D13', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E13', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F13', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G13', strtoupper($grades['remarks']));
                }
                if (strcasecmp($grades['subject_name'], "Edukasyon sa Pagpapakatao") === 0) {
                    $sheet->setCellValue('B21', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C21', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D21', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E21', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F21', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G21', strtoupper($grades['remarks']));
                }
                if (strcasecmp($grades['subject_name'], "T.L.E") === 0) {
                    $sheet->setCellValue('B23', strtoupper($grades['1st_quarter']));
                    $sheet->setCellValue('C23', strtoupper($grades['2nd_quarter']));
                    $sheet->setCellValue('D23', strtoupper($grades['3rd_quarter']));
                    $sheet->setCellValue('E23', strtoupper($grades['4th_quarter']));
                    $sheet->setCellValue('F23', strtoupper($grades['final_grade']));
                    $sheet->setCellValue('G23', strtoupper($grades['remarks']));
                }
            }

            // Create directory based on instructor_id if it doesn't exist
            $directoryPath = public_path("reportcard/{$studentLRN}");
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }

            $fileName = '(' . $schoolYear . ')' . strtoupper(str_replace(' ', '_', $studentName)) . '-Grade' . $gradeLevel . '-' . $section;

            // Save the updated file in the new directory
            $newFilePath = "{$directoryPath}/{$fileName}.xlsx";
            $writer = new Xlsx($spreadsheet);
            $writer->save($newFilePath);

            $downloadUrl = route('downloadReportCard', ['studentLRN' => $studentLRN, 'fileName' => "{$fileName}.xlsx"]);
            $download = '<a href="' . $downloadUrl . '" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i> Download</a>';

            return response()->json([
                'valid' => true,
                'msg' => 'Class records exported successfully.',
                'file_path' => $newFilePath,
                'download' => $download,
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating report card: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while generating the report card.',
            ]);
        }
    }

    public function downloadReportCard($student_lrn, $fileName)
    {
        $filePath = public_path("reportcard/{$student_lrn}/{$fileName}");

        // Check if the file exists
        if (!File::exists($filePath)) {
            abort(404, 'File not found');
        }

        // Download the file
        return response()->download($filePath, $fileName);
    }

    public function getStudentGrades($grade_level, $section)
    {
        try {
            // Step 1: Validate the user session and retrieve the student LRN
            $user = User::where('user_id', session()->get('user_id'))->firstOrFail();
            $student_lrn = $user->username;

            // Step 2: Fetch subject listings for the grade level and section
            $subjectListings = DB::table('subject_teachers')
                ->join('student_statuses', function ($join) {
                    $join->on('subject_teachers.school_year', '=', 'student_statuses.school_year')
                        ->on('subject_teachers.section', '=', 'student_statuses.section')
                        ->on('subject_teachers.grade_level', '=', 'student_statuses.grade_level');
                })
                ->where('student_statuses.student_lrn', $student_lrn)
                ->where('student_statuses.grade_level', $grade_level)
                ->where('student_statuses.section', $section)
                ->select('subject_teachers.subject_listing')
                ->get();

            // Step 3: Process each subject listing
            $grades = [];
            foreach ($subjectListings as $listing) {
                $subjectRecord = $this->fetchSubjectRecord($listing->subject_listing, $student_lrn);

                if (!$subjectRecord) {
                    continue; // Skip if the record is not found
                }

                $gradeData = $this->fetchGradeData($subjectRecord);
                if ($gradeData) {
                    $grades[] = $gradeData;
                }
            }

            // Step 4: Return the grades or a not-found message
            if (empty($grades)) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'No grades found for the specified grade level and section.',
                ]);
            }

            return response()->json($grades);
        } catch (\Exception $e) {
            // Log and handle unexpected errors
            Log::error('Error retrieving grades: ' . $e->getMessage());
            return response()->json([
                'valid' => false,
                'msg' => 'An error occurred while retrieving the grades.',
            ]);
        }
    }

    /**
     * Fetch detailed subject record for a given subject listing and student LRN.
     */
    private function fetchSubjectRecord($subject_listing, $student_lrn)
    {
        return DB::table('class_records')
            ->join('subject_teachers', 'class_records.subject_listing', '=', 'subject_teachers.subject_listing')
            ->join('teachers', 'subject_teachers.teacher_id', '=', 'teachers.teacher_id')
            ->join('subjects', 'subject_teachers.subject_code', '=', 'subjects.subject_code')
            ->join('students', 'class_records.student_lrn', '=', 'students.student_lrn')
            ->where('class_records.subject_listing', $subject_listing)
            ->where('students.student_lrn', $student_lrn)
            ->select(
                'subjects.subject_code',
                'subjects.subject_name',
                'subject_teachers.grade_level',
                'subject_teachers.section',
                'subject_teachers.school_year',
                'class_records.subject_listing',
                'students.sex',
                'teachers.last_name',
                DB::raw("CONCAT(
                    teachers.first_name,
                    ' ',
                    COALESCE(teachers.middle_name, ''),
                    ' ',
                    teachers.last_name,
                    ' ',
                    COALESCE(teachers.extension_name, '')
                ) as teacher_name"),
                DB::raw("CONCAT(
                    students.last_name,
                    ', ',
                    students.first_name,
                    ' ',
                    COALESCE(students.middle_name, '')
                ) as student_name")
            )
            ->distinct()
            ->first();
    }

    /**
     * Fetch grade data from the Excel file for a given subject record.
     */
    private function fetchGradeData($subjectRecord)
    {
        $folderDIR = $subjectRecord->subject_listing;
        $fileName = '(' . $subjectRecord->school_year . ')' . strtoupper(str_replace(' ', '_', $subjectRecord->last_name)) .
            '-Grade' . $subjectRecord->grade_level . '-' . $subjectRecord->section . '-' . $subjectRecord->subject_name . '.xlsx';
        $filePath = public_path("classrecord/{$folderDIR}/{$fileName}");

        if (!file_exists($filePath)) {
            Log::warning("File not found: {$filePath}");
            return null;
        }

        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getSheetByName('SUMMARY OF QUARTERLY GRADES');

        if (!$sheet) {
            Log::warning("Sheet not found: 'SUMMARY OF QUARTERLY GRADES'");
            return null;
        }

        $subjectName = $sheet->getCell('W9')->getCalculatedValue();
        $startRow = ($subjectRecord->sex === "Male") ? 13 : 64;
        $endRow = ($subjectRecord->sex === "Male") ? 62 : 113;

        for ($i = $startRow; $i <= $endRow; $i++) {
            $studentNameFromSheet = trim($sheet->getCell("B{$i}")->getCalculatedValue());
            if (strtolower(trim($studentNameFromSheet)) === strtolower(trim($subjectRecord->student_name))) {
                return [
                    'subject_name' => $subjectName,
                    'subject_code' => $subjectRecord->subject_code,
                    'teacher_name' => $subjectRecord->teacher_name,
                    '1st_quarter' => $sheet->getCell("F{$i}")->getCalculatedValue(),
                    '2nd_quarter' => $sheet->getCell("J{$i}")->getCalculatedValue(),
                    '3rd_quarter' => $sheet->getCell("N{$i}")->getCalculatedValue(),
                    '4th_quarter' => $sheet->getCell("R{$i}")->getCalculatedValue(),
                    'final_grade' => $sheet->getCell("V{$i}")->getCalculatedValue(),
                    'remarks' => $sheet->getCell("Z{$i}")->getCalculatedValue(),
                ];
            }
        }

        return null;
    }
}
