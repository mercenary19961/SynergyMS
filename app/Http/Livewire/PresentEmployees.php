<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use Carbon\Carbon;

class PresentEmployees extends Component
{
    public $presentEmployees;
    public $selectedEmployee = null;
    public $pollingInterval = 10000;

    public function mount()
    {
        $this->refreshPresentEmployees();
    }

    public function render()
    {
        return view('livewire.present-employees');
    }

    public function refreshPresentEmployees()
    {
        $this->presentEmployees = Attendance::whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->with(['employee.user', 'employee.department', 'employee.projects'])
            ->latest()
            ->get();
    }

    public function showEmployeeDetails($employeeId)
    {
        $this->selectedEmployee = $this->presentEmployees->firstWhere('employee.id', $employeeId);
    }

    public function closeEmployeeDetails()
    {
        $this->selectedEmployee = null;
    }

    public function getListeners()
    {
        return [
            'refreshPresentEmployees' => 'refreshPresentEmployees',
        ];
    }
}
