<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Http\Requests\StoreLeaveTypeRequest;
use App\Http\Requests\UpdateLeaveTypeRequest;
use Illuminate\Validation\ValidationException;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function store(StoreLeaveTypeRequest $request)
    {
        $leaveType = new LeaveType();
        $leaveType->name = $request->name;
        $leaveType->description = $request->description;

        $leaveType->save();

        return response()->json($leaveType,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType $leaveType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaveTypeRequest $request, $id)
    {
        try {
            $post = $request->all();

            // Find the designation by ID
            $leaveType = LeaveType::findOrFail($id);

            // Update the leave type fields
            $leaveType->name = $post['name'];
            $leaveType->description = $post['description'];

            $leaveType->save();

            // Return a response with the updated leave type
            return response()->json($leaveType, 200);

        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating leave type', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($leaveType)
    {
        try {
            // Find the leaveType by ID
            $leaveType = LeaveType::findOrFail($leaveType);

            // Delete the leaveType
            $leaveType->delete();

            // Return a success response
            return response()->json(['message' => 'leaveType deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Leave type not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting leave type', 'error' => $e->getMessage()], 500);
        }
    }
}
