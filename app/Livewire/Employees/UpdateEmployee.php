<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use App\Livewire\Forms\Employee\EmployeeForm;
use App\Models\Employee;
use \WW\Countries\Models\Country;
use App\Http\Controllers\Common\BusinessUtil;

class UpdateEmployee extends Component
{
    public $countries, $genderEnums, $maritalStatusEnums, $idTypes, $educationLevels, $terminationPeriodTypes, $payPeriods =[];

    public EmployeeForm $form;

    public function mount(Employee $employee)
    {
        $this->form->setEmployee($employee);
        $this->countries = Country::all();
        $this->maritalStatusEnums = BusinessUtil::get_enum_values('employees', 'marital_status');
        $this->genderEnums = BusinessUtil::get_enum_values('employees', 'gender');
        $this->idTypes = BusinessUtil::get_enum_values('employees', 'id_type');
        $this->educationLevels = BusinessUtil::get_enum_values('employees', 'education_level');
        $this->payPeriods = BusinessUtil::get_enum_values('employees', 'pay_period');
        $this->terminationPeriodTypes = BusinessUtil::get_enum_values('employees', 'termination_notice_period_type');
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect('/employees');
    }

    public function render()
    {
        return view('livewire.employees.add-employee');
    }
}
