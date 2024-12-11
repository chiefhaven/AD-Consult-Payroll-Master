<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
    {

        return view('leaves.leaveView');

    }

    public function leavesData()
    {
        $leaves = Leave::all();

        return response()->json($leaves, 200);

    }

    // public function massApprove(Request $request)
    // {
    //     // Validation with strict type checks
    //     $request->validate([
    //         'ids' => 'required|array|min:1', // Ensures `ids` is a non-empty array
    //         'ids.*' => 'required|exists:leaves,id', // Ensures all elements are integers and exist in the `leaves` table
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         Leave::whereIn('id', $request->input('ids'))->update(['status' => 'Approved']);
    //         DB::commit();

    //         $approvedRequests = Leave::where('status', 'Approved')->count();
    //         $disapprovedRequests = Leave::where('status', 'Disapproved')->count();
    //         $pendingRequests = Leave::where('status', 'Pending')->count();

    //         return response()->json([
    //             'approvedRequests' => $approvedRequests,
    //             'disapprovedRequests' => $disapprovedRequests,
    //             'pendingRequests' => $pendingRequests,
    //             'message' => 'Mass approval successful!',
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Failed to approve leaves', 'message' => $e->getMessage()], 500);
    //     }
    // }

    // public function massDisapprove(Request $request)
    // {
    // // Validation with strict type checks
    //     $request->validate([
    //         'ids' => 'required|array|min:1', // Ensures `ids` is a non-empty array
    //         'ids.*' => 'required|exists:leaves,id', // Ensures all elements are integers and exist in the `leaves` table
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         Leave::whereIn('id', $request->input('ids'))->update(['status' => 'Disapproved']);
    //         DB::commit();

    //         $approvedRequests = Leave::where('status', 'Approved')->count();
    //         $disapprovedRequests = Leave::where('status', 'Disapproved')->count();
    //         $pendingRequests = Leave::where('status', 'Pending')->count();

    //         return response()->json([
    //             'approvedRequests' => $approvedRequests,
    //             'disapprovedRequests' => $disapprovedRequests,
    //             'pendingRequests' => $pendingRequests,
    //             'message' => 'Mass disapproval successful!',
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Failed to disapprove leaves', 'message' => $e->getMessage()], 500);
    //     }
    // }

   public function approve($id)
{

    try {
        // Fetch the leave record and ensure it exists
        $leave = Leave::findOrFail($id);

        // Update the status to 'Approved'
        $leave->Status = 'Approved';

        $leave->save();

        // Recalculate the status counts

        $approvedRequests = Leave::where('status', 'Approved')->count();
        $disapprovedRequests = Leave::where('status', 'Disapproved')->count();
        $pendingRequests = Leave::where('status', 'Pending')->count();



        // Return success response
        return response()->json([
                'leave' => $leave,
                'approvedRequests' => $approvedRequests,
                'disapprovedRequests' => $disapprovedRequests,
                'pendingRequests' => $pendingRequests,
                'message' => ' Approval successful!',
            ]);

    } catch (\Exception $e) {
        DB::rollBack();

        // Return failure response
        return response()->json([
            'success' => false,
            'message' => 'Failed to approve leave',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function disapproveLeave($id)
{
    $leave = Leave::findOrFail($id);
    $leave->status = 'disapproved';  // Update the status to 'disapproved'
    $leave->save();  // Save the updated leave record

    // Get the updated counts for approved, disapproved, and pending leaves
    $counts = [
        'approved' => Leave::where('status', 'approved')->count(),
        'disapproved' => Leave::where('status', 'disapproved')->count(),
        'pending' => Leave::where('status', 'pending')->count()
    ];

    return response()->json($counts);  // Return the updated counts as a JSON response
}


public function show($id)
    {
        $leave = Leave::findOrFail($id);
        if (request()->ajax()) {
        return response()->json($leave);
    }

    return view('leaves.leaveDetail', compact('leave'));
    }

}