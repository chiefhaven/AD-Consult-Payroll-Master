<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::all();

        // $leaves = Leave::orderBy('start_date', 'desc')->get();

        // Consistent naming for status counts
        $approvedRequests = $leaves->where('status', 'Approved')->count();
        $disapprovedRequests = $leaves->where('status', 'Disapproved')->count();
        $pendingRequests = $leaves->where('status', 'Pending')->count();

        if (request()->wantsJson()) {
            return response()->json([
                'leaves' => $leaves,
                'approvedRequests' => $approvedRequests,
                'disapprovedRequests' => $disapprovedRequests,
                'pendingRequests' => $pendingRequests,
            ]);
        }

        return view('leaves.leaveView', compact('leaves', 'approvedRequests', 'disapprovedRequests', 'pendingRequests'));
        // return view('leaves.leaveView', compact('leaves'));

    }

    public function massApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:leaves,id',
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
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:leaves,id',
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