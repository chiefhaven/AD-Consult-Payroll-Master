<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BusinessUtil;
use App\Models\Payroll;
use App\Http\Requests\StorepayrollRequest;
use App\Http\Requests\UpdatepayrollRequest;
use App\Models\Client;
use App\Models\Employee;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payrolls = Payroll::all();
        return view("payroll.payrolls", compact("payrolls"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Client $client)
    {
        $messages = [
            'client.required' => 'The client field is required.',
            'payroll_month_year.required' => 'The payroll month and year field is required.',
            'payroll_month_year.regex' => 'The payroll month and year must be in the format "Month Year", e.g., "October 2024".',
            'employees.required' => 'The employees field must contain at least one employee.',
            'employees.array' => 'The employees field must contain at least one employee.',
            'employees.min' => 'The employees field must contain at least one employee.',
            'employees.*.required' => 'Each employee entry is required.',
        ];

        // Validation
        $this->validate($request, [
            'client'  => 'required',
            'payroll_month_year' => [
                'required',
                'regex:/^(January|February|March|April|May|June|July|August|September|October|November|December) \d{4}$/'
            ],
            'employees' => 'required|array|min:1',
        ], $messages);

        $employee_ids = request('employees');

        // Get the month-year string from the request
        $payroll_month_year = request('payroll_month_year');

        $payroll_date = BusinessUtil::date($payroll_month_year);

        // Check if payrolls exist for the specified date
        $payrolls = Payroll::where('client_id', $client->id)
        ->whereDate('payroll_date', $payroll_date)
        ->with('employees') // Load the related employees
        ->get();

        // Get the IDs of employees that have payroll records
        $payrollEmployeeIds = $payrolls->flatMap(function ($payroll) {
            return $payroll->employees->pluck('id');
        })->unique()->toArray();

        // Determine which employees do not have payroll records for the specified date
        $add_payroll_for = array_diff($employee_ids, $payrollEmployeeIds);

        if (! empty($add_payroll_for)) {

            //initialize required data
            $start_date = $payroll_date;
            $end_date = Carbon::parse($start_date)->lastOfMonth();
            $month_name = $end_date->format('F');

            $employees = Employee::where('client_id', $client->id)->where('status', 'Active')
            ->find($add_payroll_for);

            $payrolls = [];
            foreach ($employees as $employee) {
                // Get employee info and populate the payrolls array
                $tax = new BusinessUtil();

                if ($employee->paye == 1) {
                    $calculatedTax = $tax->calculatePaye($employee->basic_pay);
                    $paye = $calculatedTax;
                } else {
                    $paye = 0;
                }

                $payrolls[$employee->id] = [
                    'employee' => $employee,
                    'salary' => $employee->basic_pay,
                    'net_salary' => $employee->basic_pay - $paye,
                    'pay_period' => $employee->pay_period,
                    'bonus' => $employee->bonus,
                    'paye' =>  $paye,
                ];
            }

            // Action to determine the context of the view (e.g., create or edit)
            $action = 'create';

            // Pass the client, payrolls, and action variables to the view
            return view('payroll.addPayroll', compact('client', 'payrolls', 'action', 'payroll_month_year'));

        } else {
            Alert::error('Payroll already exist',  'Payroll already exist for the selected Employees for the specified month');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepayrollRequest $request)
    {

        $messages = [
            'payrollMonthYear.required' => 'The payroll month and year field is required.',
            'payrollStatus.required' => 'The status field is required.',
            'payrollStatus.string' => 'The status must be a string.',
            'payrollStatus.in' => 'The selected status is invalid. Please choose a valid option.',
        ];

        // Validation
        $this->validate($request, [
            'payrollMonthYear'  => 'required',
            'payrollStatus' => 'required|string|in:Draft,Cancelled,Pending Approval,Final',
        ], $messages);

        $post = $request->all();

        $payroll_month_year = $post['payrollMonthYear'];
        $status = $post['payrollStatus'];
        $client = $post['client'];

        $payroll_date = BusinessUtil::date($payroll_month_year);

        $employeePayments = $post['payroll'];

        $payroll = new payroll();
        $payroll->group = $payroll_month_year;
        $payroll->status = $status;
        $payroll->client_id = $client;
        $payroll->payroll_date = $payroll_date;
        $payroll->added_by = Auth::user()->id;

        $payroll->save();

        foreach ($employeePayments as $data) {
            // Processing each employee's payroll
            $employeeId = $data['employee'];
            $salary = (float) $data['salary'];
            $earningDescription = $data['earning_description'] ?? null;
            $earningAmount = (float) ($data['earning_amount'] ?? 0);
            $deductionDescription = $data['deduction_description'] ?? null;
            $deductionAmount = (float) ($data['deduction_amount'] ?? 0);
            $tax = new BusinessUtil();
            $paye = $tax->calculatePaye($salary);
            $payPeriod = $data['pay_period'];

            // Calculating the net salary
            $netSalary = $salary - $paye;

            // Get the most recent payroll ID
            $payrollId = Payroll::orderBy('created_at', 'desc')->first()->id;

            // Fetch the employee by ID
            $employee = Employee::find($employeeId);

            // Attach the employee to the payroll with all required details in the pivot
            if ($employee) {
                $employee->payrolls()->attach($payrollId, [
                    'salary' => $salary,
                    'pay_period' => $payPeriod,
                    'earning_description' => $earningDescription,
                    'earning_amount' => $earningAmount,
                    'deduction_description' => $deductionDescription,
                    'deduction_amount' => $deductionAmount,
                    'payee' => $paye,
                    'net_salary' => $netSalary,
                    'total_paid' => $netSalary + $earningAmount - $deductionAmount,
                ]);
            }
        }

        if(!$payroll->save()){
            return false;
        }

        // After successfully adding payroll
        Alert::toast('Payroll added successfully!', 'success');

        return redirect()->route('view-client', ['client' => $client, 'data' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(payroll $payroll)
    {
        $payroll = Payroll::with('Client', 'Employees')->find($payroll->id ?? null);

        if (!$payroll) {
            // Handle the case where the payroll is not found
            abort(404, 'Payroll not found');
        }
        return response()->json([$payroll], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payroll $payroll)
    {
        // Return the edit view with the specified payroll
        return view('payroll.editPayroll', compact('payroll'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepayrollRequest $request, payroll $payroll)
    {
        // Validate request data
        $this->validate($request, [
            'payrollMonthYear' => 'required',
            'payrollStatus' => 'required|string|in:draft,cancelled,pending_approval,final',
            'client' => 'required|exists:clients,id', // Assuming clients is a table in your database
            'payroll' => 'required|array',
            'payroll.*.employee' => 'required|exists:employees,id',
            'payroll.*.salary' => 'required|numeric',
            // Add more validation rules for earnings and deductions as needed
        ]);

        // Retrieve the request data
        $post = $request->all();
        $payrollGroupName = $post['payrollMonthYear'];
        $status = $post['payrollStatus'];
        $client = $post['client'];

        // Find the existing payroll record
        $payroll = Payroll::findOrFail($payroll->id);
        $payroll->group = $payrollGroupName;
        $payroll->status = $status;
        $payroll->client_id = $client;
        $payroll->added_by = Auth::user()->id; // Assuming this is the user who is updating the payroll

        // Update the payroll record
        if (!$payroll->save()) {
            return response()->json(['message' => 'Failed to update payroll.'], 500);
        }

        // Clear existing employee payments to avoid duplicates
        $payroll->employees()->detach();

        foreach ($post['payroll'] as $data) {
            // Processing each employee's payroll
            $employeeId = $data['employee'];
            $salary = (float) $data['salary'];
            $earningDescription = $data['earning_description'] ?? null;
            $earningAmount = (float) ($data['earning_amount'] ?? 0);
            $deductionDescription = $data['deduction_description'] ?? null;
            $deductionAmount = (float) ($data['deduction_amount'] ?? 0);

            // Assuming BusinessUtil is correctly defined
            $tax = new BusinessUtil();
            $paye = $tax->calculatePaye($salary);

            // Calculating the net salary
            $netSalary = $salary - $paye;

            // Attach the employee to the payroll with all required details in the pivot
            $employee = Employee::find($employeeId);
            if ($employee) {
                $employee->payrolls()->attach($payroll->id, [
                    'salary' => $salary,
                    'pay_period' => $data['pay_period'],
                    'earning_description' => $earningDescription,
                    'earning_amount' => $earningAmount,
                    'deduction_description' => $deductionDescription,
                    'deduction_amount' => $deductionAmount,
                    'payee' => $paye,
                    'net_salary' => $netSalary,
                    'total_paid' => $netSalary + $earningAmount - $deductionAmount,
                ]);
            }
        }

        // After successfully updating payroll
        Alert::toast('Payroll updated successfully!', 'success');

        return redirect()->route('view-client', ['client' => $client]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payroll $payroll)
    {

        // Check if the payroll entry exists
        if ($payroll) {

            // If you want to detach the employees from the payroll
            $payroll->employees()->detach();
            // Delete the payroll entry
            $payroll->delete();

            // Show success message
            Alert::toast('Payroll deleted', 'success');
        } else {
            // Show error message if not found
            Alert::toast('Payroll not found', 'error');
        }

        return back();
    }

    public function viewEmployeePayroll($employee, $payroll, $payslip)
    {
        // Fetch the specific payroll details for a particular employee
        $employeePayroll = Payroll::where('id', $payroll)
            ->whereHas('employees', function ($query) use ($employee) {
                $query->where('id', $employee);
            })
            ->with(['employees' => function ($query) use ($employee) {
                $query->where('id', $employee); // Load details for the specific employee
            }])
            ->first();

        if ($employeePayroll) {
            if ($payslip == '1') {
                // Implement PDF export logic here (using a package like DomPDF)
                $pdf = PDF::loadView('pdf.employeePayroll', ['employeePayroll' => $employeePayroll]);
                return $pdf->download($employeePayroll->employees[0]->fname . ' ' . $employeePayroll->employees[0]->sname . '.pdf');
            } else {
                return response()->json([$employeePayroll], 200);
            }
        } else {
            return response()->json(['message' => 'No data found for the provided payroll and employee ID.'], 404);
        }
    }


    public function status(Request $request)
    {
        $post = $request->all();

        // Find the payroll record by its ID
        $payrollRecord = Payroll::findOrFail($post['payroll']);

        // Update the status
        $payrollRecord->status = $post['status']; // Adjust this based on your actual field
        $payrollRecord->save();

        // Return a response
        return response()->json([
            'message' => 'Payroll status updated successfully!',
            'status' => $post['status'],
        ]);
    }

    public function exportPayroll($payroll, $type)
    {
        // Fetch payroll records for the specified client
        $payroll = Payroll::with('employees', 'client')->find($payroll);

        // Check for export type and handle accordingly
        if ($type === 'csv') {
            // Define the CSV file path
            $fileName = $payroll->client->client_name . ' payroll' . '.csv';
            $filePath = storage_path('app/public/' . $fileName);

            // Open the file for writing
            $file = fopen($filePath, 'w');

            // Add the header row
            fputcsv($file, [
                'Client Name',
                'Pay period',
                'Client Contact',
                'Client Address',
            ]);

            // Add client information row
            fputcsv($file, [
                $payroll->client->client_name,
                $payroll->group,
                $payroll->client->contact_number ?? 'N/A',
                $payroll->client->address ?? 'N/A',
                '', // Empty cell for spacing
            ]);

            // Add the header row
            fputcsv($file, [
                'Employee No',
                'Employee Name',
                'Gross',
                'PAYE',
                'Net Pay',
                'Earnings',
                'Deductions',
                'Status',
            ]);

            // Add payroll data to the CSV
            foreach ($payroll->employees as $employee) {
                fputcsv($file, [
                    $employee->employee_no,
                    $employee->fname . ' '.$employee->fname .' '. $employee->sname,
                    number_format($employee->pivot->salary, 2), // Formatting salary
                    number_format($employee->pivot->payee ?? 0, 2), // PAYE
                    number_format($employee->pivot->net_salary ?? 0, 2), // Net pay
                    number_format($employee->pivot->earning_amount ?? 0, 2), // Assuming bonus is in the pivot
                    number_format($employee->pivot->deduction_amount ?? 0, 2), // Deductions
                    $payroll->status, // Status of the payroll
                ]);
            }

            // Close the file
            fclose($file);

            // Return the file for download
            return response()->download($filePath)->deleteFileAfterSend(true);
        }
         elseif ($type === 'pdf') {
           // Implement PDF export logic here (using a package like DomPDF)
            $pdf = PDF::loadView('pdf.payroll', ['payroll' => $payroll])
            ->setPaper('A4', 'landscape'); // Set paper size and orientation

            return $pdf->download($payroll->client->client_name . ' payroll.pdf');
        } else {
            // Handle unsupported export type
            return response()->json(['error' => 'Unsupported export type'], Response::HTTP_BAD_REQUEST);
        }
    }

}
