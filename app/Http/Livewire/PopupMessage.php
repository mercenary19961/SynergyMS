<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PopupMessage extends Component
{
    public $showMessage = false;
    public $messageText = '';

    protected $listeners = ['showPopup' => 'displayPopup'];

    // Add the mount() method here
    public function mount()
    {
        if (session()->has('show_popup')) {
            $this->messageText = session('show_popup');
            $this->showMessage = true;
        }
    }

    public function closePopup()
    {
        $this->showMessage = false;
    }

    public function render()
    {
        return view('livewire.popup-message');
    }
}
