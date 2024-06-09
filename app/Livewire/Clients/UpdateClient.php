<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use App\Livewire\Forms\Client\ClientForm;
use \WW\Countries\Models\Country;
use \HavenPlus\Districts\Models\District;
use App\Http\Controllers\Common\BusinessUtil;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UpdateClient extends Component
{
    public ClientForm $form;

    use LivewireAlert;
    public $countries, $industries =[];

    public $pageTitle = 'Update Client';

    public function mount($id)
    {
        $this->form->setClient($id);

        $this->countries = Country::all();
        $this->industries = BusinessUtil::get_industry();
    }

    public function save()
    {
        $this->form->update();

        return $this->redirect('/clients');
    }

    public function render()
    {
        return view('livewire.clients.add-client');
    }
}
