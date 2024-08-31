<?php

namespace App\Livewire\Common;

use Livewire\Component;

class PageHeader extends Component
{
    public $pageTitle = '';
    public $buttonName = null;
    public $link =null;
    public $buttonClass = 'btn-primary';

    public function render()
    {
        return view('livewire.common.page-header');
    }
}
