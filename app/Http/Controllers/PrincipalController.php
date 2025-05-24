<?php

namespace App\Http\Controllers;

use App\Models\Principal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $principals = Principal::all();

            $response = $principals->map(function ($principal, $key) {
                return [
                    'count' => $key + 1,
                    'image' => '<img class="img img-fluid img-rounded" alt="User Avatar" src="' . asset($principal->image) . '" style="width: 50px;">',
                    'principal_id' => $principal->principal_id,
                    'principal_name' => trim($principal->first_name . ' ' . ($principal->middle_name ?? '') . ' ' . $principal->last_name . ' ' . ($principal->extension_name ?? '')),
                    'contact' => $principal->contact,
                    'email' => $principal->email,
                    'action' => '<a href="' . route('viewPrincipal', ['principalID' => $principal->principal_id]) . '" type="button" class="btn btn-md btn-primary" title="Update"><i class="fa fa-edit"></i></a>',
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching principals: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve principal records at the moment. Please try again later.',
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
                'principal_id' => 'required|unique:principals,principal_id',
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

            // Create a user for the principal
            $user = User::create([
                'username' => $validated['principal_id'],
                'password' => Hash::make($validated['principal_id']),
                'role' => 'principal',
            ]);

            // Create the principal record
            $principal = Principal::create(array_merge($validated, ['user_id' => $user->user_id]));

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Principal registered successfully.',
                'data' => $principal,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating principal: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the principal. Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($principal_id)
    {
        try {
            $principal = Principal::where('principal_id', $principal_id)->first();

            if (!$principal) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve the principal details at the moment. Please try again later.',
                ]);
            }

            $principal->image = asset($principal->image);


            return response()->json($principal);
        } catch (\Exception $e) {
            Log::error('Error fetching principal details: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve the principal details at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $principal_id)
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

            $principal = Principal::where('principal_id', $principal_id)->first();

            if (!$principal) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the principal details at the moment. Please try again later.',
                ]);
            }

            $principal->update($validated);
            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Principal details updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating principal: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to update the principal details. Please try again later.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($principal_id)
    {
        DB::beginTransaction();

        try {
            $principal = Principal::where('principal_id', $principal_id)->first();

            if (!$principal) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the principal details at the moment. Please try again later.',
                ]);
            }

            $principal->delete();
            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Principal deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting principal: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to delete the principal at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified principal image in storage.
     */
    public function upload(Request $request, $principal_id)
    {
        DB::beginTransaction();

        try {
            $principal = Principal::where('principal_id', $principal_id)->first();

            if (!$principal) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to update the principal image at the moment. Please try again later.',
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
            $fileFolder = $principal_id;

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
            if ($principal->image && file_exists(public_path($principal->image))) {
                $existingFile = public_path($principal->image);
                $backupPath = $uploadPath . '/backup_' . basename($principal->image);
                copy($existingFile, $backupPath); // Backup the existing file
                unlink($existingFile); // Remove the existing file after backup
            }

            // Move the new file to the public directory with the new name
            $attachment->move($uploadPath, $fileName);

            // Update the principal's image path
            $principal->update([
                'image' => $path,
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'Principal image updated successfully.',
                'image' => asset($path),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error uploading principal image: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to upload the principal image at the moment. Please try again later.',
            ]);
        }
    }
}
