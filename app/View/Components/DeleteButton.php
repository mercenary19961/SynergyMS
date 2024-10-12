<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    public $formId;

    public function __construct($formId)
    {
        $this->formId = $formId;
    }

    public function render()
    {
        return view('components.delete-button');
    }
}
    