<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;
use App\Livewire\Leaves;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Get the current year and month if not passed explicitly
    $year = request()->year ?? now()->year;   // Default to the current year
    $month = request()->month ?? now()->month; // Default to the current month

    // Fetch leave data from the database based on the year and month
    $leaves = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->orderByRaw("FIELD(status, 'pending', 'approved', 'disapproved')")
        ->orderBy('start_date', 'desc')
        ->get();

    // Count the requests based on their status
    $approvedRequests = $leaves->where('status', 'approved')->count();
    $disapprovedRequests = $leaves->where('status', 'disapproved')->count();
    $pendingRequests = $leaves->where('status', 'pending')->count();

    // Return the Blade view with the necessary data compacted
    return view('leaveView', compact('leaves', 'approvedRequests', 'disapprovedRequests', 'pendingRequests', 'year', 'month'));
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
    public function destroy(Leave $leave)
    {
        //
    }

    // public function showLeavesByYear(Request $request, $year)
    // {
    //     // Get total requests grouped by month for the specified year
    //     $leaves = DB::table('leaves')
    //         ->select(DB::raw("MONTH(start_date) as month"), DB::raw('count(*) as total_requests'))
    //         ->whereYear('start_date', $year) // Filter by the specified year
    //         ->groupBy('month')
    //         ->orderBy('month') // Ensure months are ordered
    //         ->get();

    //     // Prepare an array to hold total requests for each month
    //     $monthlyRequests = [];
    //     for ($month = 1; $month <= 12; $month++) {
    //         // Find the request count for the current month; default to 0 if not found
    //         $total = $leaves->firstWhere('month', $month);
    //         $monthlyRequests[$month] = $total ? $total->total_requests : 0;
    //     }

    //     return view('leaves.leave', compact('leave'));
    // }



public function massApprove($year, $month)
{
    // Update status to 1 (approved) for all leaves in the specified month and year
    DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->update(['status' => 1]);

    // Fetch updated counts to return as JSON
    $approvedRequests = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->where('status', 1)
        ->count();

    $disapprovedRequests = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->where('status', 0)
        ->count();

    $totalRequests = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->count();

    // Return updated data as JSON
    return response()->json([
        'approvedRequests' => $approvedRequests,
        'disapprovedRequests' => $disapprovedRequests,
        'totalRequests' => $totalRequests
    ]);
}


public function massDisapprove($year, $month)
{
    // Update status to 0 (disapproved) for all leaves in the specified month and year
    DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->update(['status' => 0]);

    // Fetch updated counts to return as JSON
    $approvedRequests = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->where('status', 1)
        ->count();

    $disapprovedRequests = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->where('status', 0)
        ->count();

    $totalRequests = DB::table('leaves')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->count();

    // Return updated data as JSON
    return response()->json([
        'approvedRequests' => $approvedRequests,
        'disapprovedRequests' => $disapprovedRequests,
        'totalRequests' => $totalRequests
    ]);
}




}