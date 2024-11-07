<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AssignedProjects extends Component
{
    public function render()
    {
        $projects = Auth::user()->employeeDetail->projects ?? collect(); // Adjust based on your relations
        return view('livewire.assigned-projects', ['projects' => $projects]);
    }
}
