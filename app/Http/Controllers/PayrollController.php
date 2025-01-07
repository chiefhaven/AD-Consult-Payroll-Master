<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Http\Requests\StorepayrollRequest;
use App\Http\Requests\UpdatepayrollRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index()
{
    // Fetch all payroll records grouped by their pay dates
    $payrolls = DB::table('payrolls')
        ->select(
            DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month_year'),
            DB::raw('SUM(net_pay) as total_net_pay'),
            DB::raw('COUNT(id) as employee_count'),
            'pay_period',
            DB::raw('CASE
                        WHEN SUM(CASE WHEN payment_status = "Draft" THEN 1 ELSE 0 END) = COUNT(id)
                        THEN "Draft"
                        ELSE "Paid"
                     END as status')
        )
        ->groupBy(DB::raw('DATE_FORMAT(payment_date, "%Y-%m")'),'pay_period')
        ->orderBy(DB::raw('DATE_FORMAT(payment_date, "%Y-%m")'), 'desc')
        ->get()
        ->groupBy('month_year');

    // Transform the results into a structured format
    $groupedPayrolls = [];
    foreach ($payrolls as $payroll) {
        $groupedPayrolls[$payroll->pay_period][$payroll->month_year][] = $payroll;
    }

    return view('payrolls.payroll_summary', compact('groupedPayrolls'));
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

        // Calculate total amount (sum of net_pay)
        $totalAmount = $groupRecords->sum('net_pay');

        // Count the number of payroll records
        $recordCount = $groupRecords->count();

        return view('payrolls.payroll', [
            'groupRecords' => $groupRecords,
            'monthYear' => $monthYear,
            'totalAmount' => $totalAmount,
            'recordCount' => $recordCount,
        ]);
    }


}