<?php

namespace App\Livewire\Employees;

use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Component;
use App\Livewire\Forms\Employee\EmployeeForm;
use \WW\Countries\Models\Country;

class AddEmployee extends Component
{
    public $countries, $genderEnums, $maritalStatusEnums, $idTypes, $educationLevels, $terminationPeriodTypes, $payPeriods =[];

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

    public EmployeeForm $form;

    public function save()
    {
        $this->form->store();

        session()->flash('message', 'Employee successfully addeded.');
        return $this->redirect('/employees');
    }

}
