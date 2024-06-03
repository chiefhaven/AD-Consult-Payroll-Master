<?php

namespace App\Livewire\Forms\Employee;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Employee;
use App\Models\TaxRate;
use App\Models\Client;
use DB;
use \WW\Countries\Models\Country;
use \HavenPlus\Districts\Models\District;
use Carbon\Carbon;

class EmployeeForm extends Form
{
    public ?Employee $employee;

    public $companies = [];

    public $country;

    #[Validate('required')]
    public float $employee_no = 12.0;

    #[Validate('required')]
    public string $prefix;

    #[Validate('required')]
    public $firstname;

    public $middlename;

    #[Validate('required')]
    public $lastname;

    #[Validate('required')]
    public $resident_street, $resident_city, $resident_state, $resident_country;

    public $permanent_street, $permanent_city, $permanent_state, $permanent_country;

    #[Validate('required')]
    public $hiredate;

    #[Validate('required')]
    public $education_level;

    #[Validate('required')]
    public $id_type;

    public $id_proof;

    #[Validate('required')]
    public $marital_status;

    #[Validate('required')]
    public $gender;

    public $bonus, $client_id;

    #[Validate('required')]
    public $nationality;

    #[Validate('required')]
    public $email;

    #[Validate('required')]
    public $phone;

    #[Validate('required')]
    public $date_of_birth;

    #[Validate('required')]
    public $employee_alt_number;

    #[Validate('required')]
    public $id_number;

    #[Validate('required')]
    public $client;

    #[Validate('required')]
    public $project = null;

    #[Validate('required')]
    public $family_contact_number;

    #[Validate('required')]
    public $family_contact_name;

    #[Validate('required')]
    public $family_contact_alt_number;

    #[Validate('required')]
    public $probation_period;

    #[Validate('required')]
    public $termination_notice_period;

    public $termination_notice_period_type;

    #[Validate('required')]
    public $designated_location;

    #[Validate('required')]
    public $designation;

    #[Validate('required')]
    public $contract_start_date;

    #[Validate('required')]
    public $contract_end_date;

    #[Validate('required')]
    public $designated_location_specifics;

    #[Validate('required')]
    public $basic_pay;

    #[Validate('required')]
    public $contract_type;

    #[Validate('required')]
    public $pay_period;

    #[Validate('required')]
    public $tax;

    public function setEmployee(Employee $employee)
    {

        $this->employee = Employee::find(53);
        $this->country = Country::find($this->employee->nationality_id)->name;

        $this->prefix = $this->employee->prefix;
        $this->firstname =$this->employee->fname;
        $this->middlename = $this->employee->mname;
        $this->lastname = $this->employee->sname;
        $this->resident_street = $this->employee->resident_street;
        $this->resident_city = $this->employee->resident_city;
        $this->resident_state = $this->employee->resident_state;
        $this->resident_country = $this->employee->resident_country;
        $this->permanent_street = $this->employee->permanent_street;
        $this->permanent_city = $this->employee->permanent_city;
        $this->permanent_state = $this->employee->permanent_state;
        $this->permanent_country = $this->employee->permanent_country;
        $this->hiredate = Carbon::parse($this->employee->hiredate)->format('Y-m-d');;
        $this->education_level = $this->employee->education_level;
        $this->id_type = $this->employee->id_type;
        $this->id_proof = $this->employee->id_proof;
        $this->id_number = $this->employee->id_number;
        $this->marital_status = $this->employee->marital_status;
        $this->gender = $this->employee->gender;
        $this->bonus = $this->employee->bonus;
        $this->nationality = $this->country;
        $this->email = $this->employee->user->email;
        $this->phone = $this->employee->phone;
        $this->employee_alt_number = $this->employee->employee_alt_number;
        $this->date_of_birth = Carbon::parse($this->employee->date_of_birth)->format('Y-m-d');
        $this->client = Client::find($this->employee->client)->firstOrFail()->client_name;
        $this->project = $this->employee->project;
        $this->family_contact_number = $this->employee->family_contact_number;
        $this->family_contact_name = $this->employee->family_contact_name;
        $this->family_contact_alt_number = $this->employee->family_contact_alt_number;
        $this->probation_period = $this->employee->probation_period;
        $this->termination_notice_period = $this->employee->termination_notice_period;
        $this->termination_notice_period_type = $this->employee->termination_notice_period_type;
        $this->designated_location = $this->employee->designated_location;
        $this->designation = $this->employee->designation;
        $this->contract_start_date = Carbon::parse($this->employee->contract_start_date)->format('Y-m-d');
        $this->contract_end_date = Carbon::parse($this->employee->contract_end_date)->format('Y-m-d');
        $this->designated_location_specifics = $this->employee->designated_location_specifics;
        $this->basic_pay = $this->employee->basic_pay;
        $this->contract_type = $this->employee->contract_type;
        $this->pay_period = $this->employee->pay_period;
        $this->tax = TaxRate::where('id', $this->employee->tax1)->firstOrFail()->name;

    }

    public function store()
    {
        $this->validate();

        $this->country = Country::where('name',$this->nationality)->id;

        try{
            Employee::create([
                'employee_no' => $this->employee_no,
                'prefix' => $this->prefix,
                'fname' => $this->firstname,
                'mname' => $this->middlename,
                'sname' => $this->lastname,
                'phone' => $this->phone,
                'employee_alt_number' => $this->employee_alt_number,
                'nationality_id' => $this->nationality,
                'client_id' => $this->client,
                'contract_type' => 1,
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
                'salary' => $this->basic_pay,
                'bonus' => 00,
                'status' => 'Active',
                'client_id' => 1,
                'pay_period' => $this->pay_period,
                'tax1' => $this->tax,
                'permanent_city' => $this->permanent_city,
                'permanent_street' => $this->permanent_street,
                'permanent_state' => $this->permanent_street,
                'permanent_country' => $this->permanent_country,
                'resident_city' => $this->resident_city,
                'resident_street' => $this->resident_street,
                'resident_state' => $this->resident_state,
                'resident_country' => $this->resident_country,
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
