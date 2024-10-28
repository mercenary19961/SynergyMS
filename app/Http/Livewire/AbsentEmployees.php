<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use Carbon\Carbon;

class AbsentEmployees extends Component
{
    public $absentEmployees;
    public $selectedAbsentEmployee = null;
    public $pollingInterval = 10000; // 10 seconds

    public function mount()
    {
        $this->refreshAbsentEmployees();
    }

    public function render()
    {
        return view('livewire.absent-employees');
    }

    public function refreshAbsentEmployees()
    {
        // Get the current date
        $currentDate = Carbon::today()->toDateString();


        $this->absentEmployees = Attendance::whereNull('clock_in')
            ->whereDate('attendance_date', $currentDate)
            ->whereIn('status', ['Absent', 'Sick Leave', 'Annual Leave'])
            ->with('employee.user')
            ->orderByRaw("FIELD(status, 'Absent', 'Sick Leave', 'Annual Leave')")
            ->latest()
            ->get();
    }

    public function showAbsentEmployeeDetails($employeeId)
    {
        // Get the specific absent employee details
        $this->selectedAbsentEmployee = $this->absentEmployees->firstWhere('employee.id', $employeeId);
    
        if ($this->selectedAbsentEmployee) {
            // Fetch the tasks associated with this employee
            $tasks = $this->selectedAbsentEmployee->employee->tasks()->get();
    
            // Set the 'tasks' relation explicitly
            $this->selectedAbsentEmployee->employee->setRelation('tasks', $tasks);
        }
    }
    

    public function closeAbsentEmployeeDetails()
    {
        $this->selectedAbsentEmployee = null;
    }

    public function getListeners()
    {
        return [
            'refreshAbsentEmployees' => 'refreshAbsentEmployees',
        ];
    }
}
