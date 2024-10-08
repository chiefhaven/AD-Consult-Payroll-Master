<?php

namespace App\Livewire\Forms\Employee;

use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Designation;
use App\Models\User;
use DB;
use \WW\Countries\Models\Country;
use \HavenPlus\Districts\Models\District;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
class EmployeeForm extends Form
{

    public ?Employee $employee;

    public $companies = [];

    public $country;

    #[Validate('required')]
    public float $employee_no = 12.0;

    public string $prefix;

    #[Validate('required')]
    public $firstname;

    public $middlename;

    #[Validate('required')]
    public $lastname;

    public $allow_login = true;

    #[Validate('required')]
    public $resident_street, $resident_city, $resident_state, $resident_country, $permanent_street, $permanent_city, $permanent_state, $permanent_country;

    #[Validate('required')]
    public $hiredate;

    #[Validate('required')]
    public $education_level;

    #[Validate('required')]
    public $id_type;

    // #[Validate('required','image|max:4096')]
    // public $id_proof_pic;

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

    public $employee_alt_number;

    #[Validate('required')]
    public $id_number;

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

    public $designated_location_specifics;

    #[Validate('required')]
    public $basic_pay;

    #[Validate('required')]
    public $contract_type;

    #[Validate('required')]
    public $pay_period;

    public $paye = true;

    public $username;

    public $password;

    public $confirm_password;

    public function setEmployee($id)
    {
        $this->employee = Employee::find($id);
        $this->country = Country::find($this->employee->nationality_id)->name;

        if(isset($this->employee->user->email)){
            $email = $this->employee->user->email;
        }
        else{
            $email = null;
        }

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
        //$this->id_proof_pic = $this->employee->id_proof;
        $this->id_number = $this->employee->id_number;
        $this->marital_status = $this->employee->marital_status;
        $this->gender = $this->employee->gender;
        $this->bonus = $this->employee->bonus;
        $this->nationality = $this->country;
        $this->email = $email;
        $this->phone = $this->employee->phone;
        $this->employee_alt_number = $this->employee->employee_alt_number;
        $this->date_of_birth = Carbon::parse($this->employee->date_of_birth)->format('Y-m-d');
        $this->client = (isset($this->employee->client_id) ? '': Client::find($this->employee->client_id)->first()->client_name);
        $this->project = $this->employee->project;
        $this->family_contact_number = $this->employee->family_contact_number;
        $this->family_contact_name = $this->employee->family_contact_name;
        $this->family_contact_alt_number = $this->employee->family_contact_alt_number;
        $this->probation_period = $this->employee->probation_period;
        $this->termination_notice_period = $this->employee->termination_notice_period;
        $this->termination_notice_period_type = $this->employee->termination_notice_period_type;
        $this->designated_location = District::find($this->employee->designated_location)->name ?? null;
        $this->designation = Designation::find($this->employee->designation_id)->name;
        $this->contract_start_date = Carbon::parse($this->employee->contract_start_date)->format('Y-m-d');
        $this->contract_end_date = Carbon::parse($this->employee->contract_end_date)->format('Y-m-d');
        $this->designated_location_specifics = $this->employee->designated_location_specifics;
        $this->basic_pay = $this->employee->salary;
        $this->contract_type = $this->employee->contract_type;
        $this->pay_period = $this->employee->pay_period;
        $this->paye = ($this->employee->paye == 1) ? true : false;
        $this->username = (isset($this->employee->user->username) ? $this->employee->user->username : '');
        $this->allow_login = ($this->allow_login == 1) ? true : false;
    }

    public function store($client)
    {
        $this->country = Country::where('name',$this->nationality)->firstOrFail()->id;


        try{
            Employee::create([
                'employee_no' => $this->employee_no,
                'prefix' => $this->prefix,
                'fname' => $this->firstname,
                'mname' => $this->middlename,
                'sname' => $this->lastname,
                'phone' => $this->phone,
                'allow_login' => $this->allow_login,
                'employee_alt_number' => $this->employee_alt_number,
                'nationality_id' => $this->country,
                'client_id' => Client::where('client_name', $client)->firstOrFail()->id,
                'contract_type' => 1,
                'designation_id' => Designation::Where('name', $this->designation)->firstOrFail()->id,
                'project_id' => $this->project,
                'hiredate' => $this->hiredate,
                'education_level' => $this->education_level,
                'workdept_id' => '',
                'designated_location' => District::Where('name',$this->designated_location)->first()->id,
                'id_type' => $this->id_type,
                'id_number' => $this->id_number,
                'marital_status' => $this->marital_status,
                'gender' => $this->gender,
                'birthdate' => $this->date_of_birth,
                'salary' => $this->basic_pay,
                'bonus' => 00,
                'status' => 'Active',
                'probation_period' => $this->probation_period,
                'pay_period' => $this->pay_period,
                'paye' => ($this->paye == true) ? 1 : 0,
                'permanent_city' => $this->permanent_city,
                'permanent_street' => $this->permanent_street,
                'permanent_state' => $this->permanent_street,
                'permanent_country' => Country::where('name', $this->permanent_country)->firstOrFail()->id,
                'resident_city' => $this->resident_city,
                'resident_street' => $this->resident_street,
                'resident_state' => $this->resident_state,
                'resident_country' => Country::where('name',$this->resident_country)->firstOrFail()->id,
                'family_contact_name'=>$this->family_contact_name,
                'family_contact_number'=>$this->family_contact_number,
                'family_contact_alt_number'=>$this->family_contact_alt_number,
            ]);

            $registerUser = new User();
                $registerUser->create([
                    'username' => Str::random(5),
                    'email' => $this->email,
                    'password' => Str::random(8),
                    'employee_id' => Employee::orderBy('created_at','DESC')->first()->id,
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
        $this->validate([
            'email' => [
                Rule::unique('users')->ignore($this->employee->user),
            ],

            'client' => [
                Rule::exists('clients','client_name'),
            ],
        ]);

        $this->country = Country::where('name',$this->nationality)->firstOrFail()->id;

        try{
            $this->employee->update(
            [
                'employee_no' => $this->employee_no,
                'prefix' => $this->prefix,
                'fname' => $this->firstname,
                'mname' => $this->middlename,
                'sname' => $this->lastname,
                'phone' => $this->phone,
                'employee_alt_number' => $this->employee_alt_number,
                'nationality_id' => $this->country,
                'client_id' => Client::where('client_name', $this->client)->firstOrFail()->id,
                'contract_type' => 1,
                'designation_id' => Designation::Where('name', $this->designation)->firstOrFail()->id,
                'project_id' => $this->project,
                'hiredate' => $this->hiredate,
                'education_level' => $this->education_level,
                'workdept_id' => '',
                'designated_location' => District::Where('name',$this->designated_location)->first()->id,
                'id_type' => $this->id_type,
                'id_number' => $this->id_number,
                'marital_status' => $this->marital_status,
                'gender' => $this->gender,
                'birthdate' => $this->date_of_birth,
                'salary' => $this->basic_pay,
                'bonus' => 00,
                'status' => 'Active',
                'probation_period' => $this->probation_period,
                'pay_period' => $this->pay_period,
                'paye' => ($this->paye == true) ? 1 : 0,
                'permanent_city' => $this->permanent_city,
                'permanent_street' => $this->permanent_street,
                'permanent_state' => $this->permanent_street,
                'permanent_country' => $this->permanent_country,
                'resident_city' => $this->resident_city,
                'resident_street' => $this->resident_street,
                'resident_state' => $this->resident_state,
                'resident_country' => $this->resident_country,
                'family_contact_name'=>$this->family_contact_name,
                'family_contact_number'=>$this->family_contact_number,
                'family_contact_alt_number'=>$this->family_contact_alt_number,
            ]);

            if(isset($this->employee->user->email)){
                try {
                    $this->updateUser(
                        $this->username,
                        $this->email,
                        'employee_id',
                        'updated_at'
                    );
                }
                catch(\Illuminate\Database\QueryException $exception){
                    $errorInfo = $exception;
                    DB::rollback();
                }
            }
            else{
                $this->registerUser(
                    Str::random(),
                    $this->email,
                    Str::random(),
                    'employee_id',
                    'updated_at'
                );
            }
        }
        catch (\Illuminate\Database\QueryException $exception){


            DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);


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
