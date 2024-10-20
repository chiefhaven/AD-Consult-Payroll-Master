<?php

namespace App\Http\Controllers;

use App\Models\HRM;
use App\Http\Requests\StoreHRMRequest;
use App\Http\Requests\UpdateHRMRequest;
use App\Models\Designation;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HRMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("hrm.hrm");
    }

    /**
     * Display a listing of the resource.
     */
    public function designationIndex()
    {
        $designations = Designation::with('employees')->get();
        return response()->json($designations);
    }

    /**
     * Store a resource.
     */
    public function storeDesignation(StoreHRMRequest $request)
    {
        $designation = new Designation();
        $designation->name = $request->name;
        $designation->description = $request->description;

        $designation->save();

        return response()->json($designation,200);

    }

    public function deleteDesignation($designation)
    {
        try {
            // Find the designation by ID
            $designation = Designation::findOrFail($designation);

            // Check if there are related employees
            if ($designation->employees()->count() > 0) {
                return response()->json(['message' => 'Cannot delete designation; there are employees assigned to this designation.'], 400);
            }

            // Delete the designation
            $designation->delete();

            // Return a success response
            return response()->json(['message' => 'Designation deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Designation not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting designation', 'error' => $e->getMessage()], 500);
        }

    }

    public function updateDesignation(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            // Find the designation by ID
            $designation = Designation::findOrFail($id);

            $designation->name = $request->name;
            $designation->description = $request->description;
            $designation->save();

            // Return a response with the updated designation
            return response()->json($designation, 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating designation', 'error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display a listing of the resource.
     */
    public function leaveTypesIndex()
    {
        $leaveTypes = LeaveType::all();
        return response()->json($leaveTypes);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHRMRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HRM $hRM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HRM $hRM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHRMRequest $request, HRM $hRM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HRM $hRM)
    {
        //
    }
}
