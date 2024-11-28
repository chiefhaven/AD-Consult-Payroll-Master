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

    public function massApprove(Request $request)
    {
        // Validation with strict type checks
        $request->validate([
            'ids' => 'required|array|min:1', // Ensures `ids` is a non-empty array
            'ids.*' => 'required|integer|exists:leaves,id', // Ensures all elements are integers and exist in the `leaves` table
        ]);

        DB::beginTransaction();

        try {
            Leave::whereIn('id', $request->input('ids'))->update(['status' => 'Approved']);
            DB::commit();

            $approvedRequests = Leave::where('status', 'Approved')->count();
            $disapprovedRequests = Leave::where('status', 'Disapproved')->count();
            $pendingRequests = Leave::where('status', 'Pending')->count();

            return response()->json([
                'approvedRequests' => $approvedRequests,
                'disapprovedRequests' => $disapprovedRequests,
                'pendingRequests' => $pendingRequests,
                'message' => 'Mass approval successful!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to approve leaves', 'message' => $e->getMessage()], 500);
        }
    }

    public function massDisapprove(Request $request)
    {
    // Validation with strict type checks
        $request->validate([
            'ids' => 'required|array|min:1', // Ensures `ids` is a non-empty array
            'ids.*' => 'required|integer|exists:leaves,id', // Ensures all elements are integers and exist in the `leaves` table
        ]);

        DB::beginTransaction();

        try {
            Leave::whereIn('id', $request->input('ids'))->update(['status' => 'Disapproved']);
            DB::commit();

            $approvedRequests = Leave::where('status', 'Approved')->count();
            $disapprovedRequests = Leave::where('status', 'Disapproved')->count();
            $pendingRequests = Leave::where('status', 'Pending')->count();

            return response()->json([
                'approvedRequests' => $approvedRequests,
                'disapprovedRequests' => $disapprovedRequests,
                'pendingRequests' => $pendingRequests,
                'message' => 'Mass disapproval successful!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to disapprove leaves', 'message' => $e->getMessage()], 500);
        }
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update(['status' => 'Approved']);

        return response()->json(['success' => true, 'message' => 'Leave approved']);
    }

    public function disapprove($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update(['status' => 'Disapproved']);

        return response()->json(['success' => true, 'message' => 'Leave disapproved']);
    }
}