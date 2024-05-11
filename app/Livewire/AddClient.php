<?php

namespace App\Livewire;

use Livewire\Component;

class AddClient extends Component
{

    public function save()
    {
        Client::create([

        ]);

        session()->flash('status', 'Post successfully updated.');

        return $this->redirect('/employees');
    }

    public function render()
    {
        return view('livewire.add-client');
    }
}
