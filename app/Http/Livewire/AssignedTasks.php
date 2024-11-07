<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AssignedTasks extends Component
{
    public function render()
    {
        $tasks = Auth::user()->employeeDetail->tasks ?? collect(); // Adjust based on your relations
        return view('livewire.assigned-tasks', ['tasks' => $tasks]);
    }
}
