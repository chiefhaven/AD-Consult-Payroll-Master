<?php

namespace App\Http\Controllers;

use App\Models\payroll;
use App\Http\Requests\StorepayrollRequest;
use App\Http\Requests\UpdatepayrollRequest;
use App\Models\Client;
use App\Models\Employee;

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
        $month_year_arr = explode('/', request('payroll_month_year'));
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
            $end_date = \Carbon::parse($start_date)->lastOfMonth();
            $month_name = $end_date->format('F');

            $employees = Employee::where('client_id', $client->id)
                            ->find($add_payroll_for);

            $payrolls = [];
            foreach ($employees as $employee) {

                //get employee info
                $payrolls[$employee->id]['name'] = $employee->user_full_name;
                $payrolls[$employee->id]['essentials_salary'] = $employee->essentials_salary;
                $payrolls[$employee->id]['essentials_pay_period'] = $employee->essentials_pay_period;

                //get total work duration of employee(attendance)
                $payrolls[$employee->id]['total_work_duration'] = $this->essentialsUtil->getTotalWorkDuration('hour', $employee->id, $business_id, $start_date, $end_date->format('Y-m-d'));

                //get total earned commission for employee
                $business_details = $this->businessUtil->getDetails($business_id);
                $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);

                $commsn_calculation_type = empty($pos_settings['cmmsn_calculation_type']) || $pos_settings['cmmsn_calculation_type'] == 'invoice_value' ? 'invoice_value' : $pos_settings['cmmsn_calculation_type'];

                $total_commission = 0;
                if ($commsn_calculation_type == 'payment_received') {
                    $payment_details = $this->transactionUtil->getTotalPaymentWithCommission($business_id, $start_date, $end_date, null, $employee->id);
                    //Get Commision
                    $total_commission = $employee->cmmsn_percent * $payment_details['total_payment_with_commission'] / 100;
                } else {
                    $sell_details = $this->transactionUtil->getTotalSellCommission($business_id, $start_date, $end_date, null, $employee->id);
                    $total_commission = $employee->cmmsn_percent * $sell_details['total_sales_with_commission'] / 100;
                }

                if ($total_commission > 0) {
                    $payrolls[$employee->id]['allowances']['allowance_names'][] = __('essentials::lang.sale_commission');
                    $payrolls[$employee->id]['allowances']['allowance_amounts'][] = $total_commission;
                    $payrolls[$employee->id]['allowances']['allowance_types'][] = 'fixed';
                    $payrolls[$employee->id]['allowances']['allowance_percents'][] = 0;
                }

                //get earnings & deductions of employee
                $allowances_and_deductions = $this->essentialsUtil->getEmployeeAllowancesAndDeductions($business_id, $employee->id, $start_date, $end_date);
                foreach ($allowances_and_deductions as $ad) {
                    if ($ad->type == 'allowance') {
                        $payrolls[$employee->id]['allowances']['allowance_names'][] = $ad->description;
                        $payrolls[$employee->id]['allowances']['allowance_amounts'][] = $ad->amount_type == 'fixed' ? $ad->amount : 0;
                        $payrolls[$employee->id]['allowances']['allowance_types'][] = $ad->amount_type;
                        $payrolls[$employee->id]['allowances']['allowance_percents'][] = $ad->amount_type == 'percent' ? $ad->amount : 0;
                    } else {
                        $payrolls[$employee->id]['deductions']['deduction_names'][] = $ad->description;
                        $payrolls[$employee->id]['deductions']['deduction_amounts'][] = $ad->amount_type == 'fixed' ? $ad->amount : 0;
                        $payrolls[$employee->id]['deductions']['deduction_types'][] = $ad->amount_type;
                        $payrolls[$employee->id]['deductions']['deduction_percents'][] = $ad->amount_type == 'percent' ? $ad->amount : 0;
                    }
                }
            }

            $action = 'create';

            return view('payroll.addPayroll', compact('client'));

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
}
