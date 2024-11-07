<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AssignedTickets extends Component
{
    public function render()
    {
        $tickets = Auth::user()->employeeDetail->tickets ?? collect(); // Adjust based on your relations
        return view('livewire.assigned-tickets', ['tickets' => $tickets]);
    }
}
