<?php

namespace App\Livewire;

use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Component;
use App\Models\Client;
use DB;
use Livewire\Attributes\Validate;
use \WW\Countries\Models\Country;
use RealRashid\SweetAlert\Facades\Alert;

class AddClient extends Component
{
    public $countries =[];

    public function mount()
    {
        $this->countries = Country::all();
    }

    #[Validate('required')]
    public float $client_no = 12.0;

    #[Validate('required')]
    public string $name;

    #[Validate('required')]
    public $currency;

    public $client_logo;

    #[Validate('required')]
    public $industry;

    #[Validate('required')]
    public $street_address;

    #[Validate('required')]
    public $street_address_2;

    #[Validate('required')]
    public $postal_code;

    #[Validate('required')]
    public $city;

    #[Validate('required')]
    public $state;

    public $password;

    #[Validate('required')]
    public $website;

    public $username;

    public $confirm_password;

    #[Validate('required')]
    public $country;

    #[Validate('required')]
    public $email;

    #[Validate('required')]
    public $phone;

    #[Validate('required')]
    public $phone2;

    #[Validate('required')]
    public $contractstartdate;

    #[Validate('required')]
    public $contractenddate;

    #[Validate('required')]
    public $tax_number;

    #[Validate('required')]
    public $tax_label;

    #[Validate('required')]
    public $tax_number_2;

    #[Validate('required')]
    public $tax_label_2 = '';

    public function save()
    {
        $this->validate();

        try{
            Client::create([
                'client_name' => $this->name,
                'contract_start_date' => $this->contractstartdate,
                'client_logo' => $this->client_logo,
                'phone' => $this->phone,
                'phone2' => $this->phone2,
                'address' => $this->street_address,
                'zip_postal_code' => $this->postal_code,
                'state' => $this->state,
                'city' => $this->city,
                'country_id' => $this->country,
                'industry_id' => $this->industry,
                'tax_number_1' => 65676,
                'tax_label_1' => 'TPIN',
                'tax_number_2' => $this->tax_number_2,
                'tax_label_2' => $this->tax_number_2,
                'time_zone' => '12/02/2024',
                'status' => 'Active',
                ]
            );
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
