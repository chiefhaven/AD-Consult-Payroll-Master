<?php
namespace App\Http\Controllers;
 use Illuminate\Http\Request;
 use App\Models\Leave;

 class LeaveController extends Controller {

    public function index($year=null, $month=null)
    { // Default to current year/month if parameters aremissing

    $year=$year ?? date('Y');
    $month=$month ?? date('m'); // Fetch leave data and counts based on year and month


    $leaves=Leave::whereYear('start_date', $year)->whereMonth('start_date', $month)->get();
    $approvedRequests = $leaves->where('status', 'Approved')->count();
    $disapprovedRequests = $leaves->where('status', 'Disapproved')->count();
    $pendingRequests = $leaves->where('status', 'Pending')->count();



    // If the request is for JSON data (API call)
    if (request()->wantsJson()) {
    return response()->json([
    'leaves' => $leaves,
    'approvedRequests' => $approvedRequests,
    'disapprovedRequests' => $disapprovedRequests,
    'pendingRequests' => $pendingRequests,
    ]);
    }

    // Otherwise, pass year, month, and leaves to the Blade view
    return view('leaves.leaveView', compact('year', 'month', 'leaves','approvedRequests', 'disapprovedRequests', 'pendingRequests'));
    }
public function massApprove($uuid)
{
    // Find the leave by UUID
    $leave = Leave::findOrFail($uuid);

    // Update logic for mass approval (if you want to handle multiple records)
    $leave->update(['status' => 'Approved']);

    // Fetch updated counts and return the JSON response
    $approvedRequests = Leave::where('status', 'Approved')->count();
    $disapprovedRequests = Leave::where('status', 'Disapproved')->count();

    return response()->json([
        'approvedRequests' => $approvedRequests,
        'disapprovedRequests' => $disapprovedRequests,
        'totalRequests' => $approvedRequests + $disapprovedRequests
    ]);
}

public function massDisapprove($uuid)
{
    // Find the leave by UUID
    $leave = Leave::findOrFail($uuid);

    // Update logic for mass disapproval
    $leave->update(['status' => 'Disapproved']);

    // Fetch updated counts and return the JSON response
    $approvedRequests = Leave::where('status', 'Approved')->count();
    $disapprovedRequests = Leave::where('status', 'Disapproved')->count();

    return response()->json([
        'approvedRequests' => $approvedRequests,
        'disapprovedRequests' => $disapprovedRequests,
        'totalRequests' => $approvedRequests + $disapprovedRequests
    ]);
    }
}