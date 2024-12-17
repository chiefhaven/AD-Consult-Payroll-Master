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
    $payrolls = Payroll::all();

    // Group by month
    $groupedPayrolls = $payrolls->groupBy(function ($payroll) {
        return Carbon::parse($payroll->payment_date)->format('Y-m');
    });

    // Calculate totals and counts for each period
    $periodGroupedPayrolls = $groupedPayrolls->map(function ($group) {
        return [
            'Monthly' => [
                'records' => $group->where('pay_period', 'Monthly'),
                'total_net_pay' => $group->where('pay_period', 'Monthly')->sum('net_pay'),
                'employee_count' => $group->where('pay_period', 'Monthly')->count(),
                'status' => $group->where('pay_period', 'Monthly')->every(fn($p) => $p->payment_status === 'Draft') ? 'Draft' : 'Paid',
            ],
            'Bi-Weekly' => [
                'records' => $group->where('pay_period', 'Bi-weekly'),
                'total_net_pay' => $group->where('pay_period', 'Bi-weekly')->sum('net_pay'),
                'employee_count' => $group->where('pay_period', 'Bi-weekly')->count(),
                'status' => $group->where('pay_period', 'Bi-weekly')->every(fn($p) => $p->payment_status === 'Draft') ? 'Draft' : 'Paid',
            ],
            'Weekly' => [
                'records' => $group->where('pay_period', 'Weekly'),
                'total_net_pay' => $group->where('pay_period', 'Weekly')->sum('net_pay'),
                'employee_count' => $group->where('pay_period', 'Weekly')->count(),
                'status' => $group->where('pay_period', 'Weekly')->every(fn($p) => $p->payment_status === 'Draft') ? 'Draft' : 'Paid',
            ],
        ];
    });

    return view('payrolls.payroll_summary', [
        'groupedPayrolls' => $periodGroupedPayrolls,
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
