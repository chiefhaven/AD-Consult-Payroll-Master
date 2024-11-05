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
public function index(Request $request)
{
    // Get the current year or the specified year from the request
    $year = $request->input('year', date('Y'));

    // Retrieve the count of start_dates for each month in the specified year
    $leaves = DB::table('leaves')
        ->select(
            DB::raw("MONTH(start_date) as month"),
            DB::raw("DATE_FORMAT(start_date, '%M') as month_name"),
            DB::raw('count(start_date) as total_requests')
        )
        ->whereYear('start_date', $year) // Filter by the specified year
        ->groupBy('month', 'month_name')
        ->orderBy('month', 'asc') // Order by month in ascending order
        ->get();

    // Prepare an array to hold total requests for each month (1-12)
    $monthlyRequests = [];
    for ($month = 1; $month <= 12; $month++) {
        // Find the request count for the current month; default to 0 if not found
        $total = $leaves->firstWhere('month', $month);
        $monthlyRequests[$month] = $total ? $total->total_requests : 0;
    }

    return view('leaves.leave', compact('monthlyRequests', 'year'));
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

     public function leaveView($year, $month)
        {
            // Fetch all leave requests where the start_date falls in the specified month and year
            $leaves = DB::table('leaves')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $month)
                ->orderBy('start_date', 'asc')
                ->get();

            // Total count of leave requests for the month
                $totalRequests = $leaves->count();

                // Count of approved leave requests (status = 1)
                $approvedRequests = $leaves->where('status', 1)->count();

                // Count of disapproved leave requests (status = 0)
                $disapprovedRequests = $leaves->where('status', 0)->count();

                return view('leaves.leaveView', compact('leaves', 'year', 'month', 'totalRequests', 'approvedRequests', 'disapprovedRequests'));
        }



        public function massApprove($year, $month)
        {
            // Update status to 1 (approved) for all leaves in the specified month and year
            DB::table('leaves')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $month)
                ->update(['status' => 1]);

            return redirect()->route('leaveView', ['year' => $year, 'month' => $month])
                ->with('success', 'All leave requests have been approved.');
        }

        public function massDisapprove($year, $month)
        {
            // Update status to 0 (disapproved) for all leaves in the specified month and year
            DB::table('leaves')
                ->whereYear('start_date', $year)
                ->whereMonth('start_date', $month)
                ->update(['status' => 0]);

            return redirect()->route('leaveView', ['year' => $year, 'month' => $month])
                ->with('success', 'All leave requests have been disapproved.');
        }




}