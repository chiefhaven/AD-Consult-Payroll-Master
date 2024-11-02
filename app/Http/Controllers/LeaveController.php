<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Http\Requests\StoreLeaveRequest;
use App\Http\Requests\UpdateLeaveRequest;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('Leaves.Leave');
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

    public function showLeavesByYear(Request $request, $year)
    {
        // Get total requests grouped by month for the specified year
        $leaves = DB::table('leaves')
            ->select(DB::raw("MONTH(start_date) as month"), DB::raw('count(*) as total_requests'))
            ->whereYear('start_date', $year) // Filter by the specified year
            ->groupBy('month')
            ->orderBy('month') // Ensure months are ordered
            ->get();

        // Prepare an array to hold total requests for each month
        $monthlyRequests = [];
        for ($month = 1; $month <= 12; $month++) {
            // Find the request count for the current month; default to 0 if not found
            $total = $leaves->firstWhere('month', $month);
            $monthlyRequests[$month] = $total ? $total->total_requests : 0;
        }

        return view('leaves.index', compact('monthlyRequests', 'year'));
    }
}