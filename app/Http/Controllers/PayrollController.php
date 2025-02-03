<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Fetch all payroll data for API requests.
     */
public function index(Request $request)
{
    // Fetch payrolls grouped by period
    $payrolls = Payroll::select(
        DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as period'),
        DB::raw('SUM(net_pay) as totalNetPay'),
        DB::raw('MAX(payment_date) as date'), // Latest date in the period
        DB::raw('COUNT(id) as recordCount'), // Count records per period
        DB::raw('MAX(payment_status) as status') // Latest status in the period
    )
    ->groupBy('period')
    ->orderBy('date', 'desc')
    ->get();

    // Return JSON if requested
    if ($request->wantsJson()) {
        return response()->json($payrolls);
    }

    // Return to Blade view
    return view('payrolls.payroll_summary', compact('payrolls'));
}


   public function show($period)
{
    // Decode period (if URL-encoded)
    $decodedPeriod = urldecode($period);

    // Fetch payroll records for the selected period
    $payrolls = Payroll::with('employee') // Load employee details
        ->select(
            'employee_id',
            'gross_pay',
            'net_pay',
            'other_deductions',
            'payment_method',
            'payment_status',
            'payment_date',
            DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as period')
        )
        ->whereRaw('DATE_FORMAT(payment_date, "%Y-%m") = ?', [$decodedPeriod])
        ->orderBy('payment_date', 'desc')
        ->get();

    // Compute summary values
    $totalAmount = $payrolls->sum('net_pay');
    $recordCount = $payrolls->count();
    $latestPayroll = $payrolls->first(); // Get latest payroll entry for additional details
    $monthYear = $decodedPeriod;

    // Pass to the view
    return view('payrolls.payroll', compact('payrolls', 'totalAmount', 'recordCount', 'monthYear', 'latestPayroll'));
}



}