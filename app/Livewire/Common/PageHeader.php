<?php

namespace App\Livewire\Common;

use Livewire\Component;

class PageHeader extends Component
{
    public $pageTitle = '';
    public $buttonName = '';

    public function render()
    {
        return view('livewire.common.page-header');
    }
}
