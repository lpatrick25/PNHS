<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $schoolYear = SchoolYear::orderBy('current', 'DESC')->get();

            // Map the results to the desired structure
            $response = $schoolYear->map(function ($list, $key) {

                $action = '';
                $actionUpdate = '<button type="button" class="btn btn-md btn-primary" title="Update" onclick="view(' . "'" . $list->school_year_id . "'" . ')"><i class="fa fa-edit"></i></button>';
                $actionUpdateDisabled = '<button type="button" class="btn btn-md btn-primary" title="Update" disabled><i class="fa fa-edit"></i></button>';
                $actionSetActive = '<button type="button" class="btn btn-md btn-success" title="Set Active" onclick="active(' . "'" . $list->school_year_id . "'" . ')"><i class="fa fa-check"></i></button>';

                if (!$list->current) {
                    $action = $actionUpdate . $actionSetActive;
                } else {
                    $action = $actionUpdateDisabled;
                }

                return [
                    'count' => $key + 1,
                    'school_year' => $list->school_year,
                    'start_date' => date('F j, Y', strtotime($list->start_date)),
                    'end_date' => date('F j, Y', strtotime($list->end_date)),
                    'current' => $list->current ? '<span class="text-success">Active</span>' : '<span class="text-danger">Not Active</span>',
                    'action' => $action,
                ];
            });

            return response()->json($response->toArray());
        } catch (\Exception $e) {
            Log::error('Error fetching school years: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve school year records at the moment. Please try again later.',
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
            $validated = $request->validate([
                'school_year' => 'required|unique:school_years,school_year',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $schoolYear = SchoolYear::create([
                'school_year' => $validated['school_year'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'current' => false,
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'School Year added successfully.',
                'data' => $schoolYear,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating school year: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Failed to register the school year. ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($school_year_id)
    {
        try {
            $schoolYear = SchoolYear::where('school_year_id', $school_year_id)->first();

            if (!$schoolYear) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve school year records at the moment. Please try again later.',
                ]);
            }

            return response($schoolYear);
        } catch (\Exception $e) {
            Log::error('Error fetching school year: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to retrieve school year records at the moment. Please try again later.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $school_year_id)
    {
        DB::beginTransaction();
        try {

            // Validate incoming data
            $validated = $request->validate([
                'school_year' => 'required|unique:school_years,school_year',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $schoolYear = SchoolYear::where('school_year_id', $school_year_id)->first();

            if (!$schoolYear) {
                return response()->json([
                    'valid' => false,
                    'msg' => 'Unable to retrieve school year records at the moment. Please try again later.',
                ]);
            }

            // Create the school year record
            $schoolYear->update([
                'school_year' => $validated['school_year'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

            DB::commit();

            return response()->json([
                'valid' => true,
                'msg' => 'School year updated successfully.',
                'data' => $schoolYear,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating school year: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'msg' => 'Unable to update school year records at the moment. Please try again later.',
            ]);
        }
    }
}
