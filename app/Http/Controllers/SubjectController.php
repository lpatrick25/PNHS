<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subjects = Subject::orderBy('subject_code')->get();

            // Map the results to the desired structure
            $response = $subjects->map(function ($list, $key) {
                return [
                    'count' => $key + 1,
                    'subject_code' => $list->subject_code,
                    'subject_name' => $list->subject_name,
                    'action' => '<button type="button" class="btn btn-md btn-primary" title="Update" onclick="view(' . "'" . $list->subject_code . "'" . ')"><i class="fa fa-edit"></i></button>',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching subjects: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
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
                'subject_code' => 'required|unique:subjects,subject_code',
                'subject_name' => 'required',
            ]);

            // Create the subject record
            $subject = Subject::create([
                'subject_code' => $validated['subject_code'],
                'subject_name' => $validated['subject_name'],
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Subject added successfully.',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating subject: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the subject. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($subject_code)
    {
        try {
            $subjects = Subject::where('subject_code', $subject_code)->first();

            if (!$subjects) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
                ]);
            }

            return response($subjects);
        } catch (\Exception $e) {
            Log::error('Error fetching subject: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $subject_code)
    {
        try {

            $subject = Subject::where('subject_code', $subject_code)->first();

            if (!$subject) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
                ]);
            }

            $subject->update([
                'subject_code' => $request->subject_code,
                'subject_name' => $request->subject_name,
            ]);

            return response()->json([
                'valid' => true,
                'msg' => 'Subject updated successfully.',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating subject: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to update subject records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subject_code)
    {
        try {
            $subject = Subject::where('subject_code', $subject_code)->first();

            if (!$subject) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve subject records at the moment. Please try again later.',
                ]);
            }

            $subject->delete();

            return response()->json([
                'valid' => true,
                'msg' => 'Subject deleted successfully.',
                'data' => $subject,
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting subject: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to delete subject records at the moment. Please try again later.',
            ]);
        }
    }

    public function checkSubjectCode(Request $request)
    {
        $subject_code = $request->input('subject_code');
        $exists = DB::table('subjects')->where('subject_code', $subject_code)->exists();

        return response()->json(!$exists);
    }
}
