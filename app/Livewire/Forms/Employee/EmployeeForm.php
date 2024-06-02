<?php

namespace App\Livewire\Forms\Employee;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Employee;
use DB;

class EmployeeForm extends Form
{
    public ?Employee $employee;

    #[Validate('required')]
    public float $employee_no = 12.0;

    #[Validate('required')]
    public string $prefix = '';

    #[Validate('required')]
    public $firstname ='';

    #[Validate('required')]
    public $middlename = '';

    #[Validate('required')]
    public $surname = '';

    #[Validate('required')]
    public $employee_current_address = '';

    #[Validate('required')]
    public $employee_permanent_address ='';

    #[Validate('required')]
    public $hiredate = '';

    #[Validate('required')]
    public $education_level = 'BSC';

    #[Validate('required')]
    public $id_type = 'Malawi National ID';

    public $id_proof = '';

    #[Validate('required')]
    public $marital_status = 'Married';

    #[Validate('required')]
    public $gender = 'Other';

    public $bonus = '';

    public $client_id = '';

    #[Validate('required')]
    public $nationality = '';

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $phone = '';

    #[Validate('required')]
    public $date_of_birth = '';

    #[Validate('required')]
    public $employee_alt_number = '';

    #[Validate('required')]
    public $id_number = '';

    #[Validate('required')]
    public $company = '';

    #[Validate('required')]
    public $project = '';

    #[Validate('required')]
    public $family_contact_number = '';

    #[Validate('required')]
    public $family_contact_name = '';

    #[Validate('required')]
    public $family_contact_alt_number = '';

    #[Validate('required')]
    public $probation_period = '';

    #[Validate('required')]
    public $termination_notice_period = '';

    public $termination_notice_period_type = '';

    #[Validate('required')]
    public $designated_location = '';

    #[Validate('required')]
    public $designation = '';

    #[Validate('required')]
    public $contract_start_date = '';

    #[Validate('required')]
    public $contract_end_date = '';

    #[Validate('required')]
    public $designated_location_specifics = '';

    #[Validate('required')]
    public $basic_pay = '';

    #[Validate('required')]
    public $contract_type = '';

    #[Validate('required')]
    public $pay_period = '';

    #[Validate('required')]
    public $tax = '';

    public function setEmployee(Employee $employee)
    {
        $this->employee = Employee::find($employee->id);
        $this->prefix = $this->employee->prefix;
        $this->firstname =$this->employee->fname;
        $this->middlename = $this->employee->mname;
        $this->surname = $this->employee->sname;
        $this->employee_current_address = $this->employee->employee_current_address;
        $this->employee_permanent_address =$this->employee->employee_permanent_address;
        $this->hiredate = '';
        $this->education_level = $this->employee->education_level;
        $this->id_type = $this->employee->id_type;
        $this->id_proof = $this->employee->id_proof;
        $this->id_number = $this->employee->id_number;
        $this->marital_status = $this->employee->marital_status;
        $this->gender = $this->employee->gender;
        $this->bonus = $this->employee->bonus;
        $this->nationality = $this->employee->nationality;
        $this->email = $this->employee->user->email;
        $this->phone = $this->employee->phone;
        $this->employee_alt_number = $this->employee->employee_alt_number;
        $this->date_of_birth = $this->employee->date_of_birth ;
        $this->company = $this->employee->company;
        $this->project = $this->employee->project;
        $this->family_contact_number = $this->employee->family_contact_number;
        $this->family_contact_name = $this->employee->family_contact_name;
        $this->family_contact_alt_number = $this->employee->family_contact_alt_number;
        $this->probation_period = $this->employee->probation_period;
        $this->termination_notice_period = $this->employee->termination_notice_period;
        $this->termination_notice_period_type = $this->employee->termination_notice_period_type;
        $this->designated_location = $this->employee->designated_location;
        $this->designation = $this->employee->designation;
        $this->contract_end_date = $this->employee->contract_end_date;
        $this->designated_location_specifics = $this->employee->designated_location_specifics;
        $this->basic_pay = $this->employee->basic_pay;
        $this->contract_type = $this->employee->contract_type;
        $this->pay_period = $this->employee->pay_period;
        $this->tax = $this->employee->tax;

    }

    public function store()
    {

        try{
            Employee::create([
                'employee_no' => $this->employee_no,
                'prefix' => $this->prefix,
                'fname' => $this->firstname,
                'mname' => $this->middlename,
                'sname' => $this->surname,
                'phone' => $this->phone,
                'employee_alt_number' => $this->employee_alt_number,
                'nationality_id' => $this->nationality,
                'client_id' => $this->company,
                'contract_type' => 1,
                'designation_id' => $this->designation,
                'project' => $this->project,
                'hiredate' => $this->hiredate,
                'education_level' => $this->education_level,
                'workdept_id' => '',
                'designation_id' => $this->designation,
                'id_type' => $this->id_type,
                'id_number' => $this->id_number,
                'id_proof_pic' => $this->id_proof,
                'marital_status' => $this->marital_status,
                'gender' => $this->gender,
                'birthdate' => $this->date_of_birth,
                'salary' => 500000.00,
                'bonus' => 00,
                'status' => 'Active',
                'client_id' => 1,
                'pay_period' => 'Hourly',
                'tax1' => $this->tax,
                'permanent_city' => $this->employee_permanent_address,
                'permanent_street' => $this->employee_permanent_address,
                'permanent_state' => $this->employee_permanent_address,
                'permanent_country' => $this->employee_permanent_address,
                'current_city' => $this->employee_current_address,
                'current_street' => $this->employee_current_address,
                'current_state' => $this->employee_current_address,
                'current_country' => $this->employee_current_address,
            ]);
        }
        catch (\Illuminate\Database\QueryException $exception){


            DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);


        }
    }

    public function update()
    {
        $this->employee->update(
            $this->all()
        );
    }
}
