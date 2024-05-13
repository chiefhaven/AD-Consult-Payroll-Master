<?php

namespace App\Livewire;

use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Component;
use DB;
use Livewire\Attributes\Validate;
use \WW\Countries\Models\Country;
use RealRashid\SweetAlert\Facades\Alert;

class AddClient extends Component
{
    public $world, $currencies, $countries, $genderEnums, $maritalStatusEnums, $idTypes, $educationLevels, $terminationPeriodTypes, $payPeriods =[];

    public function mount()
    {
        $this->countries = Country::all();
    }

    #[Validate('required')]
    public float $client_no = 12.0;

    #[Validate('required')]
    public string $name;

    public $currency;

    #[Validate('required')]
    public $client_logo;

    #[Validate('required')]
    public $industry = '';

    #[Validate('required')]
    public $street_address = '';

    #[Validate('required')]
    public $street_address_2 = '';

    #[Validate('required')]
    public $postal_code = '';

    #[Validate('required')]
    public $city = '';

    #[Validate('required')]
    public $state = '';

    #[Validate('required')]
    public $password = '';

    #[Validate('required')]
    public $website = '';

    #[Validate('required')]
    public $username = '';

    #[Validate('required')]
    public $confirm_password = '';

    public $country = '';

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $phone = '';

    #[Validate('required')]
    public $phone2 = '';

    #[Validate('required')]
    public $contractstartdate = '';

    #[Validate('required')]
    public $contractenddate = '';

    #[Validate('required')]
    public $tax_number = '';

    #[Validate('required')]
    public $tax_label = '';

    #[Validate('required')]
    public $tax_number_2 = '';

    #[Validate('required')]
    public $tax_label_2 = '';

    public function save()
    {
        $this->validate();

        try{
            Client::create([
                'client_no' => $this->client_no,
                'client_name' => $this->name,
                'currency_id' => $this->firstname,
                'start_date' => $this->middlename,
                'client_logo' => $this->surname,
                'phone' => $this->phone,
                'phone2' => $this->employee_alt_number,
                'address' => $this->nationality,
                'zip_postal_code' => $this->company,
                'state' => $this->contract_type,
                'city' => $this->designation,
                'country_id' => $this->project,
                'industry_id' => $this->hiredate,
                'tax_number_1' => $this->education_level,
                'tax_lable_1' => '',
                'tax_number_2' => $this->designation,
                'tax_label_2' => $this->id_type,
                'time_zone' => $this->id_number,
                'status' => 'Active',
                ]
            );

            Alert::toast('Client successifully added', 'success');
            return $this->redirect('/clients');
        }
        catch (\Illuminate\Database\QueryException $exception){

            DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);


        }
    }

    public function render()
    {
        return view('livewire.add-client');
    }
}
