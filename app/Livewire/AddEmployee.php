<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Component;
use DB;
use Livewire\Attributes\Validate;
use \WW\Countries\Models\Country;

class AddEmployee extends Component
{
    public $countries =[];
    public $genderEnums =[];
    public $maritalStatusEnums, $idTypes, $educationLevels, $terminationPeriodTypes, $payPeriods =[];

    public function mount()
    {
        $this->countries = Country::all();
        $this->maritalStatusEnums = BusinessUtil::get_enum_values('employees', 'marital_status');
        $this->genderEnums = BusinessUtil::get_enum_values('employees', 'gender');
        $this->idTypes = BusinessUtil::get_enum_values('employees', 'id_type');
        $this->educationLevels = BusinessUtil::get_enum_values('employees', 'education_level');
        $this->payPeriods = BusinessUtil::get_enum_values('employees', 'pay_period');
        $this->terminationPeriodTypes = BusinessUtil::get_enum_values('employees', 'termination_notice_period_type');
    }

    #[Validate('required')]
    public float $employee_no = 12.0;

    #[Validate('required')]
    public string $prefix;

    #[Validate('required')]
    public $firstname;

    #[Validate('required')]
    public $middlename = '';

    #[Validate('required')]
    public $surname;

    #[Validate('required')]
    public $employee_current_address = '';

    #[Validate('required')]
    public $employee_permanent_address ='';

    #[Validate('required')]
    public $hiredate = '';

    #[Validate('required')]
    public $education_level = '';

    #[Validate('required')]
    public $workdept_id = '';

    #[Validate('required')]
    public $designation_id = '';

    #[Validate('required')]
    public $id_type;

    #[Validate('required')]
    public $id_proof = '';

    #[Validate('required')]
    public $marital_status = '';

    #[Validate('required')]
    public $gender = '';

    #[Validate('required')]
    public $salary = '';

    #[Validate('required')]
    public $bonus = '';

    #[Validate('required')]
    public $contact_id = '';

    #[Validate('required')]
    public $cilent_id = '';

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

    public function save()
    {
        $this->validate();

        try{
            Employee::create([
                'employee_no' => $this->employee_no,
                'prefix' => $this->prefix,
                'fname' => $this->firstname,
                'mname' => $this->middlename,
                'sname' => $this->surname,
                'phone' => $this->phone,
                'phone2' => $this->employee_alt_number,
                'nationality' => $this->nationality,
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
                'marital_status' => 'Married',
                'gender' => $this->gender,
                'birthdate' => $this->date_of_birth,
                'salary' => 500000.00,
                'bonus' => 00,
                'status' => 'Active',
                'contact_id' => 1,
                'client_id' => 1,
                'pay_period' => $this->pay_period,
                'tax1' => $this->tax,
                'permanent_address' => $this->employee_permanent_address,
                'current_address' => $this->employee_current_address,
                ]
            );

            session()->flash('status', 'Post successfully updated.');
            return $this->redirect('/employees');
        }
        catch (\Illuminate\Database\QueryException $exception){

            DB::rollback();
            $errorInfo = $exception->errorInfo;


        }
    }

    public function render()
    {
        return view('livewire.add-employee');
    }
}
