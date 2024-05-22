<?php

namespace App\Livewire\Clients;

use Livewire\Component;

class ViewClient extends Component
{
    public $client;

    public function render()
    {
        return view('livewire.clients.view-client');
    }
}
