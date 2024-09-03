<?php

namespace App\Livewire\Employees;

use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Component;
use App\Livewire\Forms\Employee\EmployeeForm;
use App\Models\Client;
use Illuminate\Validation\Rule;
use \WW\Countries\Models\Country;
use \HavenPlus\Districts\Models\District;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class AddEmployee extends Component
{
    use WithFileUploads;

    public $countries, $districts, $clients, $genderEnums, $maritalStatusEnums, $idTypes, $educationLevels, $terminationPeriodTypes, $payPeriods =[];

    public $clientName, $pageTitle = null;

    public $client;

    #[Validate('required','image|max:4096')]
    public $id_proof_pic;

    public function mount($clientName)
    {
        $this->countries = Country::all();
        $this->districts = District::all();
        $this->maritalStatusEnums = BusinessUtil::get_enum_values('employees', 'marital_status');
        $this->genderEnums = BusinessUtil::get_enum_values('employees', 'gender');
        $this->idTypes = BusinessUtil::get_enum_values('employees', 'id_type');
        $this->educationLevels = BusinessUtil::get_enum_values('employees', 'education_level');
        $this->payPeriods = BusinessUtil::get_enum_values('employees', 'pay_period');
        $this->terminationPeriodTypes = BusinessUtil::get_enum_values('employees', 'termination_notice_period_type');
        $this->client = $clientName;
    }

    public EmployeeForm $form;

    public function save()
    {
        $this->validate([
            'client' => [
                Rule::exists('clients','client_name')
            ],
        ]);

        $this->form->store($this->client);

        session()->flash('message', 'Employee successfully addeded.');
        return $this->redirect('/employees');
    }

    public function autocompleteclientSearch()
    {
        $this->client = $this->form->client;
        $var = new BusinessUtil;
        return $this->clients = $var->autocompleteclientSearch($this->client);
    }

}
