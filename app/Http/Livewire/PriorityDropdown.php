<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PriorityDropdown extends Component
{
    public $selectedPriority;
    public $openPriority = false; // Initialize the state

    public function selectPriority($priority)
    {
        $this->selectedPriority = $priority;
        $this->openPriority = false; // Close the dropdown after selection
    }

    public function togglePriorityDropdown()
    {
        $this->openPriority = !$this->openPriority; // Toggle the dropdown
    }

    public function render()
    {
        return view('livewire.priority-dropdown');
    }
}
