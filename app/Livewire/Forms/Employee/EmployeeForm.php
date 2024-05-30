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
        $this->employee = $employee;
        $this->prefix = $employee->prefix;
        $this->firstname ='';
        $this->middlename = '';
        $this->surname = '';
        $this->employee_current_address = '';
        $this->employee_permanent_address ='';
        $this->hiredate = '';
        $this->education_level = 'BSC';
        $this->id_type = 'Malawi National ID';
        $this->id_proof = '';
        $this->id_number = 'VBM801QJ';
        $this->marital_status = 'Married';
        $this->gender = 'Other';
        $this->bonus = '';
        $this->nationality = '';
        $this->email = '';
        $this->phone = '';
        $this->employee_alt_number = '';
        $this->date_of_birth = '';
        $this->company = '';
        $this->project = '';
        $this->family_contact_number = '';
        $this->family_contact_name = '';
        $this->family_contact_alt_number = '+265';
        $this->probation_period = '3';
        $this->termination_notice_period = '30';
        $this->termination_notice_period_type = 'Days';
        $this->designated_location = 'Lilongwe';
        $this->designation = 'Accountant';
        $this->contract_end_date = '05/22/2025';
        $this->designated_location_specifics = '';
        $this->basic_pay = '500,000';
        $this->contract_type = 'Part time';
        $this->pay_period = 'Monthly';
        $this->tax = 'Payee';

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
                'phone2' => $this->employee_alt_number,
                'nationality_id' => $this->nationality,
                'client_id' => $this->company,
                'contract_type_id' => $this->contract_type,
                'designation_id' => $this->designation,
                'project_id' => $this->project,
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
                'pay_period' => $this->pay_period,
                'tax1' => $this->tax,
                'permanent_address' => $this->employee_permanent_address,
                'current_address' => $this->employee_current_address,
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
