<?php

namespace App\Livewire\Payroll;

use Livewire\Component;

class AddPayroll extends Component
{
    public $client;

    public function mount($clientName)
    {
        $this->client = $clientName;
    }

    public function render()
    {
        return view('livewire.payroll.add-payroll');
    }
}
