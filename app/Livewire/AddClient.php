<?php

namespace App\Livewire;

use Livewire\Component;
use \WW\Countries\Models\Country;
use App\Livewire\Forms\Client\ClientForm;
use RealRashid\SweetAlert\Facades\Alert;

class AddClient extends Component
{
    public $countries =[];

    public function mount()
    {
        $this->countries = Country::all();
    }

    public ClientForm $form;

    public function save()
    {
        $this->form->store();

        session()->flash('status', 'Cieint successfully updated.');
        return $this->redirect('/clients');
    }

    public function render()
    {
        return view('livewire.add-client');
    }
}
