<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
                    'action' => '<a href="' . route('viewTeacher', ['teacherID' => $teacher->teacher_id]) . '" type="button" class="btn btn-md btn-primary" title="Update"><i class="fa fa-edit"></i></a>',
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate incoming data
            $validated = $request->validate([
                'teacher_id' => 'required|unique:teachers,teacher_id',
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
                'civil_status' => 'required|string|max:15',
                'email' => 'required|email|max:50',
                'contact' => 'required|string|max:20',
            ]);

            // Create a user for the teacher
            $user = User::create([
                'username' => $validated['teacher_id'],
                'password' => Hash::make($validated['teacher_id']),
                'role' => 'teacher',
            ]);

            // Create the teacher record
            $teacher = Teacher::create(array_merge($validated, ['user_id' => $user->user_id]));

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Teacher registered successfully.',
                'data' => $teacher,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the teacher. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($teacher_id)
    {
        try {
            $teacher = Teacher::where('teacher_id', $teacher_id)->first();

            if (!$teacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve the teacher details at the moment. Please try again later.',
                ]);
            }

            $teacher->image = asset($teacher->image);


            return response()->json($teacher);
        } catch (\Exception $e) {
            Log::error('Error fetching teacher details: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve the teacher details at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $teacher_id)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
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
                'civil_status' => 'required|string|max:15',
                'email' => 'required|email|max:50',
                'contact' => 'required|string|max:20',
            ]);

            $teacher = Teacher::where('teacher_id', $teacher_id)->first();

            if (!$teacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the teacher details at the moment. Please try again later.',
                ]);
            }

            $teacher->update($validated);
            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Teacher details updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to update the teacher details. Please try again later.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($teacher_id)
    {
        DB::beginTransaction();

        try {
            $teacher = Teacher::where('teacher_id', $teacher_id)->first();

            if (!$teacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the teacher details at the moment. Please try again later.',
                ]);
            }

            $teacher->delete();
            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Teacher deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting teacher: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to delete the teacher at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified teacher image in storage.
     */
    public function upload(Request $request, $teacher_id)
    {
        DB::beginTransaction();

        try {
            $teacher = Teacher::where('teacher_id', $teacher_id)->first();

            if (!$teacher) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the teacher image at the moment. Please try again later.',
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
            $fileFolder = $teacher_id;

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
            if ($teacher->image && file_exists(public_path($teacher->image))) {
                $existingFile = public_path($teacher->image);
                $backupPath = $uploadPath . '/backup_' . basename($teacher->image);
                copy($existingFile, $backupPath); // Backup the existing file
                unlink($existingFile); // Remove the existing file after backup
            }

            // Move the new file to the public directory with the new name
            $attachment->move($uploadPath, $fileName);

            // Update the teacher's image path
            $teacher->update([
                'image' => $path,
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Teacher image updated successfully.',
                'image' => asset($path),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error uploading teacher image: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to upload the teacher image at the moment. Please try again later.',
            ]);
        }
    }
}
