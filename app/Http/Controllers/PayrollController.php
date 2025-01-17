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
    // Fetch all payroll records grouped by their pay dates and periods
    $payrolls = DB::table('payrolls')
        ->select(
            'id', // Include individual record ID
            DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month_year'), // Group by year-month
            'net_pay', // Include individual net pay
            'payment_status as status', // Include individual status
            DB::raw('IFNULL(pay_period, "Unknown") as pay_period') // Handle null pay_period
        )
        ->orderBy(DB::raw('DATE_FORMAT(payment_date, "%Y-%m")'), 'desc') // Sort by month-year
        ->get()
        ->groupBy('pay_period'); // Group by pay_period for structured data

$groupedPayrolls = [];
    foreach ($payrolls as $payPeriod => $records) {
        $totalNetPay = 0; // Initialize total net pay for this pay period
        foreach ($records as $record) {
            $groupedPayrolls[$payPeriod][$record->month_year][] = [
                'net_pay' => $record->net_pay,
                'status' => $record->status,
            ];
            $totalNetPay += $record->net_pay; // Accumulate total net pay
        }
        // Add total net pay for the pay period
        $groupedPayrolls[$payPeriod]['totalNetPay'] = $totalNetPay;
    }


    // Pass the structured data to the view
    return view('payrolls.payroll_summary', compact('groupedPayrolls'));
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