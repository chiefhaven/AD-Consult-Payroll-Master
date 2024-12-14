<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Http\Requests\StorepayrollRequest;
use App\Http\Requests\UpdatepayrollRequest;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Fetch all payroll data
    $payrolls = Payroll::all();

    // Group payrolls by year and month
    $groupedPayrolls = $payrolls->groupBy(function($payroll) {
        return Carbon::parse($payroll->payment_date)->format('Y-m'); // Format as 'year-month'
    });


    // Calculate total net pay for each month
    $totalsByMonth = $groupedPayrolls->map(function($group) {
        return [
            'total_net_pay' => $group->sum('net_pay'), // Sum of net_pay only
            'employee_count' => $group->count(), // Count of records (number of employees)
            'status' => $group->every(fn($payroll) => $payroll->payment_status === 'Draft') ? 'Draft' : 'Paid',

        ];
    });


    // Return the view with grouped data and totals
    return view('payrolls.payroll_summary', [
        'groupedPayrolls' => $groupedPayrolls,
        'totalsByMonth' => $totalsByMonth
    ]);
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
    public function store(StorepayrollRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepayrollRequest $request, payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payroll $payroll)
    {
        //
    }

    public function showGroup($monthYear)
    {
        // Fetch records for the specified group and include related employee data
        $groupRecords = Payroll::with('employee')
            ->whereYear('payment_date', substr($monthYear, 0, 4))
            ->whereMonth('payment_date', substr($monthYear, 5, 2))
            ->get();

        return view('payrolls.payroll', [
            'groupRecords' => $groupRecords,
            'monthYear' => $monthYear,
        ]);
    }


}
