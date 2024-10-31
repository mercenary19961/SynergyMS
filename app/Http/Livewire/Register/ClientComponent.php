<?php

namespace App\Http\Livewire\Register;

use Livewire\Component;

class ClientComponent extends Component
{
    public $company_name, $industry, $address, $website, $contact_number;

    public function render()
    {
        return view('livewire.register.client-component');
    }
}
