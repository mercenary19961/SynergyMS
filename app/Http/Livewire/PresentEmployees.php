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
            ->with([
                'employee.user',
                'employee.department',
                'employee.projects' => function ($query) {
                    // Add any conditions here if necessary, 
                    // but this is mainly to ensure only related projects are being fetched
                    $query->distinct();
                }
            ])
            ->latest()
            ->get();
    }
    

    public function showEmployeeDetails($employeeId)
    {
        // Find the selected employee from the present employees collection
        $this->selectedEmployee = $this->presentEmployees->firstWhere('employee.id', $employeeId);
    
        if ($this->selectedEmployee) {
            // Fetch the tasks associated with this employee
            $tasks = $this->selectedEmployee->employee->tasks()->get();
    
            // Set the 'tasks' relation explicitly to ensure it contains the correct data
            $this->selectedEmployee->employee->setRelation('tasks', $tasks);
        }
    
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
