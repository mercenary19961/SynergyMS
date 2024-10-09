<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BackButton extends Component
{
    public $route;

    public function __construct($route = null)
    {
        $this->route = $route;
    }

    public function render()
    {
        return view('components.back-button');
    }
}
