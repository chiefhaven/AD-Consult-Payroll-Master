<?php

namespace App\Livewire\Forms\Client;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Client;
use DB;

class ClientForm extends Form
{
    public float $client_no = 12.0;

    #[Validate('required')]
    public string $name = '';

    public $client_logo = '';

    public $industry = '';

    public $street_address = '';

    public $street_address_2 = '';

    public $postal_code;

    #[Validate('required')]
    public $city = '';

    public $state = '';

    public $password = '';

    public $website = '';

    public $username = '';

    public $confirm_password = '';

    #[Validate('required')]
    public $country = '';

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $phone = '';

    public $phone2 = '';

    #[Validate('required')]
    public $contractstartdate = '';

    public $contractenddate = '';

    public $tax_number = '';

    public $tax_label = '';

    public $tax_number_2 = '';

    public $tax_label_2 = '';

    public string $project = '';

    public function store()
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
                'tax_number_1' => $this->tax_number,
                'tax_label_1' => $this->tax_label,
                'tax_number_2' => $this->tax_number_2,
                'tax_label_2' => $this->tax_number_2,
                'time_zone' => '12/02/2024',
                'status' => 'Active',
                ]
            );
        }
        catch (\Illuminate\Database\QueryException $exception){

            DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);


        }
    }
}
