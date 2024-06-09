<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use \WW\Countries\Models\Country;
use App\Livewire\Forms\Client\ClientForm;
use RealRashid\SweetAlert\Facades\Alert;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Controllers\Common\BusinessUtil;

class AddClient extends Component
{
    use LivewireAlert;
    public $countries =[];
    public $industries =[];
    public $pageTitle = 'Add Client';

    public function mount()
    {
        $this->countries = Country::all();
        $this->industries = BusinessUtil::get_industry();
    }

    public ClientForm $form;

    public function save()
    {
        $this->form->store();

        $this->alert('success', 'Successfully added client, redirecting...',[
            'position' => 'center',
            'timer' => 10000,
            'toast' => true,
            'timerProgressBar' => true,
            'customClass' => [
                'htmlContainer' => 'card'
               ]
            ]
        );

        return $this->redirect('/clients');
    }

}
