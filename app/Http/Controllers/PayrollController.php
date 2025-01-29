<?php

namespace App\Http\Controllers;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Fetch payroll data with filters and pagination for API requests.
     */public function index(Request $request)
{
    $period = $request->input('filter', 'All');
    $page = $request->input('page', 1);

    // Create a base query
    $payrollsQuery = Payroll::select(
        'id',
        DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month_year'),
        'net_pay',
        'payment_status as status',
        'pay_period'
    );

    // Apply filter if specified
    if ($period !== 'All') {
        $payrollsQuery->where('pay_period', $period);
    }

    // Paginate the data
    $payrollData = $payrollsQuery->paginate(10);
    $totalNetPay = $payrollData->sum('net_pay');
    $lastPage = $payrollData->lastPage();

    if($request->wantsJson()) {
        return response()->json([
            'data' => $payrollData,
            'totalNetPay' => $totalNetPay,
            'currentPage' => $page,
            'lastPage' => $lastPage
        ]);
    }

    return view('payrolls.payroll_summary', compact('payrollData'));
}
}