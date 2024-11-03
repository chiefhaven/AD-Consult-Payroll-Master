<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Leave::with('employee', 'approvedByUser')->get();
        return response()->json($leaves);
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
    public function store(StoreLeaveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeaveRequest $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($leave)
    {
        try {
            // Find the leaveType by ID
            $leave = Leave::findOrFail($leave);

            // Delete the leaveType
            $leave->delete();

            // Return a success response
            return response()->json(['message' => 'Leave deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Leave not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting leave', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Leave approval.
     */
    public function leaveApproval(UpdateLeaveRequest $request, Leave $leave)
    {
        // The UpdateLeaveRequest validates the 'status' field
        $validatedData = $request->validated();

        // Update the leave status
        $leave->status = $validatedData['status'];
        $leave->approval_date = Carbon::now();
        $leave->approval_by = Auth::user()->id;
        $leave->save();

        // Return a JSON response
        return response()->json([
            'message' => 'Leave status updated successfully',
            'status' => $leave->status,
        ], 200);
    }

}
