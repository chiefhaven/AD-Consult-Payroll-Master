<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BusinessUtil;
use App\Models\payroll;
use App\Http\Requests\StorepayrollRequest;
use App\Http\Requests\UpdatepayrollRequest;
use App\Models\Client;
use App\Models\Employee;
use Carbon\Carbon;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Client $client)
    {
        $employee_ids = request('employees');
        $payroll_month_year = request('payroll_month_year');
        $month_year_arr = explode('-', request('payroll_month_year'));
        $month = $month_year_arr[0];
        $year = $month_year_arr[1];

        $payroll_date = $year.'-'.$month.'-01';

        //check if payrolls exists for the month year
        $payrolls = Payroll::where('client_id', $client->id)
                    ->whereDate('payroll_date', $payroll_date)
                    ->get();

        $add_payroll_for = array_diff($employee_ids, $payrolls->pluck('payroll_employee')->toArray());

        if (! empty($add_payroll_for)) {

            //initialize required data
            $start_date = $payroll_date;
            $end_date = Carbon::parse($start_date)->lastOfMonth();
            $month_name = $end_date->format('F');

            $employees = Employee::where('client_id', $client->id)
            ->find($add_payroll_for);

            $payrolls = [];
            foreach ($employees as $employee) {
                // Get employee info and populate the payrolls array
                $payrolls[$employee->id] = [
                    'employee' => $employee,
                    'salary' => $employee->salary,
                    'pay_period' => $employee->pay_period,
                    'bonus' => $employee->bonus,
                    'payee' => $employee->paye,
                ];
            }

            // Action to determine the context of the view (e.g., create or edit)
            $action = 'create';

            // Pass the client, payrolls, and action variables to the view
            return view('payroll.addPayroll', compact('client', 'payrolls', 'action', 'payroll_month_year'));

        } else {
            return redirect()->back()
                ->with('status',
                    [
                        'success' => true,
                        'msg' => __('essentials::lang.payroll_already_added_for_given_user'),
                    ]
                );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepayrollRequest $request)
    {
        //dd(request()->all());
        $messages = [
            'payrollGroupName.required' => 'Payroll Group Name is required',
            'payrollStatus.required'   => 'Payroll Status is required',
        ];

        // Validate the request
        $this->validate($request, [
            'payrollGroupName'  =>'required',
            'payrollStatus'   =>'required',

        ], $messages);

        $post = $request->all();
        $payrollGroupName = $post['payrollGroupName'];
        $status = $post['payrollStatus'];
        $client = $post['client'];

        $employeePayments = $post['payroll'];

        $payroll = new payroll();
        $payroll->group = $payrollGroupName;
        $payroll->status = $status;
        $payroll->client_id = $client;
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
}
