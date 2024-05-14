<?php

namespace App\Livewire\Forms\Employee;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Employee;
use DB;

class EmployeeForm extends Form
{
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
}
