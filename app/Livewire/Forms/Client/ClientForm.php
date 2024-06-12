<?php

namespace App\Livewire\Forms\Client;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Common\BusinessUtil;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Form;
use App\Models\Client;
use App\Models\Industry;
use App\Models\User;
use DB;
use \WW\Countries\Models\Country;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ClientForm extends Form
{

    use LivewireAlert;

    public ?Client $client;

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

    public $time_zone;

    public $status;

    public function rules()
    {
        return [
            'email' => [
                'required',
            ],
        ];
    }

    public function setClient($id)
    {
        $this->client = Client::find($id);

        if(isset($this->client->user->email)){
            $email = $this->client->user->email;
        }
        else{
            $email = null;
        }

        if(isset($this->client->user->username)){
            $username = $this->client->user->username;
        }
        else{
            $username = null;
        }

        $this->name = $this->client->client_name;
        $this->contractstartdate = $this->client->contract_start_date;
        $this->contractenddate = $this->client->contract_end_date;
        $this->email = $email;
        $this->phone = $this->client->phone;
        $this->phone2 = $this->client->phone2;
        $this->project = $this->client->project;
        $this->street_address = $this->client->street_address;
        $this->street_address_2 = $this->client->street_address_2;
        $this->postal_code = $this->client->zip_postal_code;
        $this->website = $this->client->website;
        $this->state = $this->client->state;
        $this->city = $this->client->city;
        $this->country = Country::find($this->client->country_id)->name;
        $this->industry = Industry::find($this->client->industry_id)->name;
        $this->tax_number = $this->client->tax_number_1;
        $this->tax_label = $this->client->tax_label_1;
        $this->tax_number_2 = $this->client->tax_number_2;
        $this->tax_label_2 = $this->client->tax_label_2;
        $this->time_zone = $this->client->time_zone;
        $this->status = $this->client->status;
        $this->username = $username;

    }

    public function store()
    {
        $this->validate([
            'email' => [
                Rule::unique('users'),
            ],
        ]);

        try{
            Client::create([
                'client_name' => $this->name,
                'contract_start_date' => $this->contractstartdate,
                'phone' => $this->phone,
                'phone2' => $this->phone2,
                'street_address' => $this->street_address,
                'address_address_2' => $this->street_address,
                'zip_postal_code' => $this->postal_code,
                'state' => $this->state,
                'city' => $this->city,
                'country_id' => Country::where('name',$this->country)->firstOrFail()->id,
                'industry_id' => BusinessUtil::get_industry_id($this->industry),
                'project' => $this->project,
                'tax_number_1' => $this->tax_number,
                'tax_label_1' => $this->tax_label,
                'tax_number_2' => $this->tax_number_2,
                'tax_label_2' => $this->tax_label_2,
                'time_zone' => 'Africa/Blantyre',
                'status' => 'Active',
                'website' => $this->website,

                ]
            );
            $client_id = Client::orderBy('created_at','DESC')->first()->id;
            User::create([
                'username' => ($this->username == null ? Str::random(8): $this->username ),
                'email' => $this->email,
                'password' => Hash::make(Str::random(8)),
                'client_id' => $client_id,
            ]);

        }
        catch (\Illuminate\Database\QueryException $exception){

            DB::rollback();
            $errorInfo = $exception->errorInfo;
            dd($errorInfo);


        }

        $this->reset();
    }

    public function update()
    {
        $this->validate([
            'email' => [
                Rule::unique('users')->ignore($this->client->user),
            ],
        ]);

        $this->country = Country::where('name',$this->country)->firstOrFail()->id;

        try{
            $this->client->update(
            [
                'client_name' => $this->name,
                'contract_start_date' => $this->contractstartdate,
                'contract_end_date' => $this->contractenddate,
                'phone' => $this->phone,
                'phone2' => $this->phone2,
                'street_address' => $this->street_address,
                'street_address_2' => $this->street_address,
                'zip_postal_code' => $this->postal_code,
                'state' => $this->state,
                'city' => $this->city,
                'country_id' => $this->country,
                'project' => $this->project,
                'industry_id' => BusinessUtil::get_industry_id($this->industry),
                'tax_number_1' => $this->tax_number,
                'tax_label_1' => $this->tax_label,
                'tax_number_2' => $this->tax_number_2,
                'tax_label_2' => $this->tax_label_2,
                'time_zone' => 'Africa/Blantyre',
                'status' => 'Active',
                'website' => $this->website,
            ]);

            if(isset($this->client->user->email)){
                try {
                    $this->client->user->update([
                        'username' => $this->username,
                        'email' => $this->email,
                        'password' => Hash::make($this->password),
                    ]);
                }
                catch(\Illuminate\Database\QueryException $exception){
                    $errorInfo = $exception;
                    DB::rollback();
                }
            }
            else{
                $client_id = Client::orderBy('updated_at','DESC')->first()->id;
                User::create([
                    'username' => ($this->username == null ? Str::random(8): $this->username ),
                    'email' => $this->email,
                    'password' => Hash::make(Str::random(8)),
                    'client_id' => $client_id,
                ]);
            }
        }
        catch (\Illuminate\Database\QueryException $exception){

            $errorInfo = $exception;
            DB::rollback();


        }
    }
}
