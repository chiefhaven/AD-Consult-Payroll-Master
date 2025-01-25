<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Fetch all payroll data
    $payrolls = DB::table('payrolls')
        ->select(
            'id',
            DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month_year'), // Group by year-month
            'net_pay', // Individual net pay
            'payment_status as status', // Payment status
            DB::raw('IFNULL(pay_period, "Unknown") as pay_period') // Handle null pay_period
        )
        ->orderBy(DB::raw('DATE_FORMAT(payment_date, "%Y-%m")'), 'desc') // Sort by month-year
        ->get();

    // Initialize groupedPayrolls array
    $groupedPayrolls = [];

    foreach ($payrolls as $record) {
        $monthYear = $record->month_year; // e.g., "2025-01"
        $payPeriod = $record->pay_period; // e.g., "Weekly", "Bi-Weekly", "Monthly"

        // Ensure the month-year group exists
        if (!isset($groupedPayrolls[$monthYear])) {
            $groupedPayrolls[$monthYear] = [
                'totalNetPay' => 0,
                'records' => [], // Array to hold all records for this month
            ];
        }

        // Add the individual record to the month-year group
        $groupedPayrolls[$monthYear]['records'][] = [
            'id' => $record->id,
            'pay_period' => $payPeriod,
            'net_pay' => $record->net_pay,
            'status' => $record->status,
        ];

        // Accumulate the total net pay for this month
        $groupedPayrolls[$monthYear]['totalNetPay'] += $record->net_pay;
    }

    // Pass the structured data to the view
    return view('payrolls.payroll_summary', compact('groupedPayrolls'));
}



    /**
     * Display records for a specific month-year group.
     */
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