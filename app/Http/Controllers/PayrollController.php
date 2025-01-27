<?php

namespace App\Http\Controllers;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Fetch payroll data with filters and pagination for API requests.
     */
    public function index(Request $request)
    {
        // Get the selected filter (defaults to 'All')
        $filter = $request->input('filter', 'All');
        $page = $request->input('page', 1);  // Current page (pagination)

        // Create a base query
        $payrollsQuery = Payroll::select(
            'id',
            DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month_year'),
            'net_pay',
            'payment_status as status',
            'pay_period'
        );

        // Apply filter if specified
        if ($filter !== 'All') {
            $payrollsQuery->where('pay_period', $filter);
        }

        // Paginate the data (e.g., 10 items per page)
        $payrolls = $payrollsQuery->paginate(10);

        // Return the data in JSON format
        // return response()->json([
        //     'data' => $payrolls->items(),
        //     'totalNetPay' => $payrolls->sum('net_pay'),
        //     'currentPage' => $payrolls->currentPage(),
        //     'lastPage' => $payrolls->lastPage(),
        // ]);
        return view('payrolls.payroll_summary', [
    'data' => $payrolls->items(),
    'totalNetPay' => $payrolls->sum('net_pay'),
    'currentPage' => $payrolls->currentPage(),
    'lastPage' => $payrolls->lastPage(),
    'perPage' => $payrolls->perPage(),
    'total' => $payrolls->total()
]);
    }
}