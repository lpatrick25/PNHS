<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index()
    {
        try {
            $students = Student::all();

            $response = $students->map(function ($student, $key) {
                return [
                    'count' => $key + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($student->image) . '" style="width: 50px;">',
                    'rfid_no' => $student->rfid_no,
                    'student_lrn' => $student->student_lrn,
                    'student_name' => trim($student->first_name . ' ' . ($student->middle_name ?? '') . ' ' . $student->last_name . ' ' . ($student->extension_name ?? '')),
                    'contact' => $student->contact,
                    'email' => $student->email,
                    'action' => '<a href="' . route('viewStudent', ['studentLRN' => $student->student_lrn]) . '" type="button" class="btn btn-md btn-primary" title="Update"><i class="fa fa-edit"></i></a>',
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
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate incoming data
            $validated = $request->validate([
                'student_lrn' => 'required|unique:students,student_lrn',
                'rfid_no' => 'required|numeric',
                'first_name' => 'required',
                'middle_name' => 'nullable',
                'last_name' => 'required',
                'extension_name' => 'nullable',
                'province_code' => 'required|exists:provinces,province_code',
                'municipality_code' => 'required|exists:municipalities,municipality_code',
                'brgy_code' => 'required|exists:brgys,brgy_code',
                'zip_code' => 'required|integer',
                'religion' => 'required|string|max:50',
                'birthday' => 'required|date',
                'sex' => 'required|string|in:Male,Female',
                'disability' => 'required|string|max:50',
                'email' => 'required|email|max:50',
                'parent_contact' => 'required|string|max:20',
                'contact' => 'required|string|max:20',
                'present_province_code' => 'required|exists:provinces,province_code',
                'present_municipality_code' => 'required|exists:municipalities,municipality_code',
                'present_brgy_code' => 'required|exists:brgys,brgy_code',
                'present_zip_code' => 'required|integer',
                'mother_first_name' => 'required',
                'mother_middle_name' => 'nullable',
                'mother_last_name' => 'required',
                'mother_address' => 'required',
                'father_first_name' => 'required',
                'father_middle_name' => 'nullable',
                'father_last_name' => 'required',
                'father_suffix' => 'nullable',
                'father_address' => 'required',
                'guardian' => 'nullable',
                'guardian_address' => 'nullable',
            ]);

            // Create a user for the student
            $user = User::create([
                'username' => $validated['student_lrn'],
                'password' => Hash::make($validated['student_lrn']),
                'role' => 'student',
            ]);

            // Create the student record
            $student = Student::create(array_merge($validated, ['user_id' => $user->user_id]));

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Student registered successfully.',
                'data' => $student,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating student: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the student. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified student.
     */
    public function show($student_lrn)
    {
        try {
            $student = Student::where('student_lrn', $student_lrn)->first();

            if (!$student) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve the student details at the moment. Please try again later.',
                ]);
            }

            $student->image = asset($student->image);


            return response()->json($student);
        } catch (\Exception $e) {
            Log::error('Error fetching student details: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve the student details at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, $student_lrn)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'rfid_no' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'province_code' => 'required|exists:provinces,province_code',
                'municipality_code' => 'required|exists:municipalities,municipality_code',
                'brgy_code' => 'required|exists:brgys,brgy_code',
                'zip_code' => 'required|integer',
                'religion' => 'required',
                'birthday' => 'required|date',
                'sex' => 'required',
                'disability' => 'required',
                'email' => 'required|email',
                'parent_contact' => 'required',
                'contact' => 'required',
                'present_province_code' => 'required|exists:provinces,province_code',
                'present_municipality_code' => 'required|exists:municipalities,municipality_code',
                'present_brgy_code' => 'required|exists:brgys,brgy_code',
                'present_zip_code' => 'required|integer',
                'mother_first_name' => 'required',
                'mother_last_name' => 'required',
                'mother_address' => 'required',
                'father_first_name' => 'required',
                'father_last_name' => 'required',
                'father_address' => 'required',
            ]);

            $student = Student::where('student_lrn', $student_lrn)->first();

            if (!$student) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the student details at the moment. Please try again later.',
                ]);
            }

            $student->update($validated);
            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Student details updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating student: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to update the student details. Please try again later.',
            ]);
        }
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy($student_lrn)
    {
        DB::beginTransaction();

        try {
            $student = Student::where('student_lrn', $student_lrn)->first();

            if (!$student) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the student details at the moment. Please try again later.',
                ]);
            }

            $student->delete();
            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Student deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting student: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to delete the student at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified student image in storage.
     */
    public function upload(Request $request, $student_lrn)
    {
        DB::beginTransaction();

        try {
            $student = Student::where('student_lrn', $student_lrn)->first();

            if (!$student) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the student image at the moment. Please try again later.',
                ]);
            }

            // Validate the incoming request
            $validatedData = $request->validate([
                'attachment' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            if (!$request->hasFile('attachment')) {
                throw new \Exception('Attachment file not found.');
            }

            // Handle the uploaded file
            $attachment = $request->file('attachment');
            $fileFolder = $student_lrn;

            // Get the file extension
            $extension = $attachment->getClientOriginalExtension();

            // Construct the new file name
            $fileName = $fileFolder . '.' . $extension;

            // Define the path
            $path = 'upload/' . $fileFolder . '/' . $fileName;

            // Create the directory if it doesn't exist
            $uploadPath = public_path('upload/' . $fileFolder);
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Backup existing file if present
            if ($student->image && file_exists(public_path($student->image))) {
                $existingFile = public_path($student->image);
                $backupPath = $uploadPath . '/backup_' . basename($student->image);
                copy($existingFile, $backupPath); // Backup the existing file
                unlink($existingFile); // Remove the existing file after backup
            }

            // Move the new file to the public directory with the new name
            $attachment->move($uploadPath, $fileName);

            // Update the student's image path
            $student->update([
                'image' => $path,
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Student image updated successfully.',
                'image' => asset($path),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error uploading student image: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to upload the student image at the moment. Please try again later.',
            ]);
        }
    }
}
