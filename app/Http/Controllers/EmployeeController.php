<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Client;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employees.employeeList');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Client $client)
    {
        return view('employees.employeeAdd', compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee = $employee->load('User','Payrolls', 'Client', 'Designation');
        return view('employees.employeeView', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.employeeUpdate');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Check if the employee has any associated payrolls
        if ($employee->payrolls()->exists()) {
            // Show an error and prevent deletion
            Alert::error('Cannot delete employee', 'Empoyee has existing payrolls.');
            return back();
        }

        // If no payrolls are found, proceed with deletion
        $employee->delete();
        Alert::toast('Employee deleted successfully.','success');
        return back();
    }

    public function export($client, $type)
    {
        // Fetch employees for the specified client
        $employees = Employee::where('client_id', $client)->get();
        $client = Client::find( $client );

        // Check for export type and handle accordingly
        if ($type === 'csv') {
            // Define the CSV file path
            $fileName = $client->client_name .' employees' . '.csv';
            $filePath = storage_path('app/public/' . $fileName);

            // Open the file for writing
            $file = fopen($filePath, 'w');

            // Add the header row
            fputcsv($file, [
                'Employee No',
                'Prefix',
                'First Name',
                'Middle Name',
                'Surname',
                'Family Contact Name',
                'Family Contact Number',
                'Family Contact Alt Number',
                'Phone',
                'Employee Alt Number',
                'Nationality ID',
                'Resident State',
                'Resident City',
                'Resident Country',
                'Resident Street',
                'Permanent State',
                'Permanent City',
                'Permanent Country',
                'Permanent Street',
                'Hire Date',
                'Education Level',
                'Designated Location',
                'Work Department ID',
                'Designation ID',
                'Designated Location Specifics',
                'Termination Notice Period',
                'Termination Notice Period Type',
                'ID Type',
                'ID Number',
                'Marital Status',
                'Contract Type',
                'Gender',
                'Birth Date',
                'Contract Start Date',
                'Contract End Date',
                'Salary',
                'Bonus',
                'Basic Pay',
                'Pay Period',
                'Status',
                'Subjected to PAYE',
                'Probation Period',
            ]);

            // Add employee data to the CSV
            foreach ($employees as $employee) {
                fputcsv($file, [
                    $employee->employee_no,
                    $employee->prefix,
                    $employee->fname,
                    $employee->mname,
                    $employee->sname,
                    $employee->family_contact_name,
                    $employee->family_contact_number,
                    $employee->family_contact_alt_number,
                    $employee->phone,
                    $employee->employee_alt_number,
                    $employee->nationality_id,
                    $employee->resident_state,
                    $employee->resident_city,
                    $employee->resident_country,
                    $employee->resident_street,
                    $employee->permanent_state,
                    $employee->permanent_city,
                    $employee->permanent_country,
                    $employee->permanent_street,
                    $employee->hiredate->format('Y-m-d'), // Format date as needed
                    $employee->education_level,
                    $employee->designated_location,
                    $employee->workdept_id,
                    $employee->designation_id,
                    $employee->designated_location_specifics,
                    $employee->termination_notice_period,
                    $employee->termination_notice_period_type,
                    $employee->id_type,
                    $employee->id_number,
                    $employee->marital_status,
                    $employee->contract_type,
                    $employee->gender,
                    $employee->birthdate ? $employee->birthdate->format('Y-m-d') : null, // Format date as needed
                    $employee->contract_start_date ? $employee->contract_start_date->format('Y-m-d') : null,
                    $employee->contract_end_date ? $employee->contract_end_date->format('Y-m-d') : null,
                    $employee->salary,
                    $employee->bonus,
                    $employee->basic_pay,
                    $employee->pay_period,
                    $employee->status,
                    $employee->paye ? 'Yes' : 'No',
                    $employee->project_id,
                    $employee->probation_period,
                ]);
            }

            // Close the file
            fclose($file);

            // Return the file for download
            return response()->download($filePath)->deleteFileAfterSend(true);
        } elseif ($type === 'pdf') {
            // Implement PDF export logic here (using a package like DomPDF)
            $pdf = PDF::loadView('pdf.employees', ['employees' => $employees, 'client'=> $client]);
            return $pdf->download( $client->client_name.'employees.pdf');

        } else {
            // Handle unsupported export type
            return response()->json(['error' => 'Unsupported export type'], Response::HTTP_BAD_REQUEST);
        }
    }

}
