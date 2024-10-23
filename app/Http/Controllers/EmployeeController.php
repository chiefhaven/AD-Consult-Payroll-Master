<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BusinessUtil;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Client;
use App\Models\Designation;
use App\Models\Projects;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use HavenPlus\Districts\Models\District;
use WW\Countries\Models\Country;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.employeeList', compact('employees'));
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
        $countries = Country::all();
        $districts = District::orderBy('name', 'ASC')->get();
        $maritalStatusEnums = BusinessUtil::get_enum_values('employees', 'marital_status');
        $genderEnums = BusinessUtil::get_enum_values('employees', 'gender');
        $idTypes = BusinessUtil::get_enum_values('employees', 'id_type');
        $educationLevels = BusinessUtil::get_enum_values('employees', 'education_level');
        $payPeriods = BusinessUtil::get_enum_values('employees', 'pay_period');
        $terminationPeriodTypes = BusinessUtil::get_enum_values('employees', 'termination_notice_period_type');

        $employee = Employee::find($employee->id);

        return view('employees.employeeUpdate', compact(
            'employee',
            'countries',
            'districts',
            'maritalStatusEnums',
            'genderEnums',
            'idTypes',
            'educationLevels',
            'payPeriods',
            'terminationPeriodTypes'
        ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        // Check if the employee has an associated user
        $userExists = isset($employee->user);

        $messages = [
            'employee_number.required' => 'Employee number is required.',
            'employee_number.unique' => 'This employee number already exists.',
            'prefix.required' => 'Prefix is required.',
            'firstname.required' => 'First name is required.',
            'middlename.required' => 'Middle name is required.',
            'lastname.required' => 'Surname is required.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number format is invalid. It must be between 10 and 15 digits.',
            'employee_alt_number.regex' => 'Alternate phone number format is invalid. It must be between 10 and 15 digits.',
            'nationality.required' => 'Nationality is required.',
            'client.exists' => 'The selected client does not exist.',
            'designation.exists' => 'The selected designation does not exist.',
            'project.exists' => 'The selected project does not exist.',
            'hiredate.required' => 'Hire date is required.',
            'hiredate.date' => 'Hire date must be a valid date.',
            'education_level.required' => 'Education level is required.',
            'id_type.required' => 'ID type is required.',
            'id_number.required' => 'ID number is required.',
            'marital_status.required' => 'Marital status is required.',
            'marital_status.in' => 'Marital status must be one of the following: Married, Divorced, Single, Widow, Other.',
            'gender.required' => 'Gender is required.',
            'birthdate.required' => 'Birth date is required.',
            'birthdate.date' => 'Birth date must be a valid date.',
            'basic_pay.required' => 'Basic pay is required.',
            'basic_pay.numeric' => 'Basic pay must be a valid number.',
            'probation_period.required' => 'Probation period is required.',
            'pay_period.required' => 'Pay period is required.',
            'pay_period.in' => 'Pay period must be one of the following: Monthly, Weekly, Bi Weekly, Daily, Hourly.',
            'permanent_city.required' => 'Permanent city is required.',
            'permanent_street.required' => 'Permanent street is required.',
            'permanent_state.required' => 'Permanent state is required.',
            'permanent_country.required' => 'Permanent country is required.',
            'resident_city.required' => 'Resident city is required.',
            'resident_street.required' => 'Resident street is required.',
            'resident_state.required' => 'Resident state is required.',
            'resident_country.required' => 'Resident country is required.',
            'family_contact_name.required' => 'Family contact name is required.',
            'family_contact_number.required' => 'Family contact number is required.',
            'family_contact_number.regex' => 'Family contact number format is invalid. It must be between 10 and 15 digits.',
            'family_contact_alt_number.regex' => 'Family alternate contact number format is invalid. It must be between 10 and 15 digits.',
        ];

        // Define validation rules
        $rules = [
            'employee_number' => 'required|string',
            'prefix' => 'required|string',
            'firstname' => 'required|string',
            'mname' => 'nullable|string',
            'lastname' => 'required|string',
            'phone' => 'required|string',
            'employee_alt_number' => 'nullable|string',
            'nationality' => 'required|string',
            'client' => 'required|exists:clients,id',
            'contract_type' => 'required|string|in:Permanent,Partime,Contract',
            'designation' => 'required|exists:designations,id',
            'project' => 'nullable|exists:projects,id',
            'hiredate' => 'required|date',
            'education_level' => 'nullable|string',
            'designated_location' => 'nullable|string',
            'id_type' => 'required|string',
            'id_number' => 'required|string',
            'marital_status' => 'required|string|in:Married,Divorced,Single,Widow,Other',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'basic_pay' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'status' => 'required|string|in:Pending,Active,Contract terminated,Contract ended,Suspended,On Probation',
            'probation_period' => 'required|integer',
            'pay_period' => 'required|string|in:Monthly,Weekly,Bi Weekly,Daily,Hourly',
            'permanent_city' => 'nullable|string',
            'permanent_street' => 'nullable|string',
            'permanent_state' => 'nullable|string',
            'permanent_country' => 'required|string',
            'resident_city' => 'nullable|string',
            'resident_street' => 'nullable|string',
            'resident_state' => 'nullable|string',
            'resident_country' => 'required|string',
            'family_contact_name' => 'nullable|string',
            'family_contact_number' => 'nullable|string',
            'family_contact_alt_number' => 'nullable|string',
        ];

        // Add conditional validation for email and username if the user exists
        if ($userExists) {
            $rules['email'] = 'required|email|unique:users,email,' . $employee->user->id;
            $rules['username'] = 'required|string|unique:users,username,' . $employee->user->id;
        }
        else {
            // If user does not exist, you can make these fields optional or handle as needed
            $rules['email'] = 'required|email|unique:users,email';
            $rules['username'] = 'required|string|unique:users,username';
        }

        // Validation
        $this->validate($request, $rules, $messages);

        $data = $request->all();

        // Use a transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Update employee details
            $employee->update([
                'employee_no' => $data['employee_number'] ?? null,
                'prefix' => $data['prefix'],
                'fname' => $data['firstname'],
                'mname' => $data['middlename'],
                'sname' => $data['lastname'],
                'phone' => $data['phone'],
                'employee_alt_number' => $data['employee_alt_number'],
                'nationality' => $data['nationality'],
                'client_id' => $data['client'],
                'contract_type' => $data['contract_type'],
                'designation_id' => $data['designation'],
                'project_id' => $data['project'] ?? '',
                'hiredate' => $data['hiredate'],
                'education_level' => $data['education_level'],
                'workdept_id' => '',
                'designated_location' => $data['designated_location'],
                'id_type' => $data['id_type'],
                'id_number' => $data['id_number'],
                'marital_status' => $data['marital_status'],
                'gender' => $data['gender'],
                'birthdate' => $data['birthdate'],
                'basic_pay' => $data['basic_pay'],
                'bonus' => 0,
                'status' => 'Active',
                'probation_period' => $data['probation_period'],
                'pay_period' => $data['pay_period'],
                'permanent_city' => $data['permanent_city'],
                'permanent_street' => $data['permanent_street'],
                'permanent_state' => $data['permanent_state'],
                'permanent_country' => $data['permanent_country'],
                'resident_city' => $data['resident_city'],
                'resident_street' => $data['resident_street'],
                'resident_state' => $data['resident_state'],
                'resident_country' => $data['resident_country'],
                'family_contact_name' => $data['family_contact_name'],
                'family_contact_number' => $data['family_contact_number'],
                'family_contact_alt_number' => $data['family_contact_alt_number'],
                'contract_end_date' => $data['contract_end_date'],
            ]);

            // Check for updating the user account linked to the employee
            if (isset($employee->user)) {
                $employee->user->update([
                    'email' => $data['email'],
                    'username' => $data['username'],
                ]);
            } else {
                // Create new user if not already linked
                User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'employee_id' => $employee->id,
                ]);
            }
            // Commit the transaction
            DB::commit();

            Alert::toast('Employee updated successfully.', 'success');
            return redirect()->route('view-client', ['client' => $data['client']])->with('success', 'Employee updated successfully.');

        } catch (\Illuminate\Database\QueryException $exception) {
            DB::rollback();

            // Log the error for debugging (you can also use Log::error for more control)
            \Log::error('Error updating employee: ', ['error' => $exception->getMessage()]);

            return redirect()->back()->withErrors('An error occurred while updating the employee.'.$exception->getMessage());
        }
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

    public function registerUser($username, $email, $password, $relationshipColumn, $recentActivity){
        $registerUser = new User();
                $registerUser->create([
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    $relationshipColumn => Employee::orderBy($recentActivity,'DESC')->first()->id,
                ]);
    }

    public function updateUser($username, $email, $relationshipColumn, $recentActivity){
        $updateUser = new User();
                $updateUser->update([
                    'email' => $email,
                    'username' => $username,
                    $relationshipColumn => Employee::orderBy($recentActivity,'DESC')->first()->id,
                ]);
    }

}
