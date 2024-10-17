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

        // Fetch absent employees for the current day, followed by sick leave, then annual leave
        $this->absentEmployees = Attendance::whereNull('clock_in') // Absent
            ->where('attendance_date', $currentDate) // Filter by today's date
            ->whereIn('status', ['absent', 'sick', 'annual']) // Only these statuses
            ->with('employee.user')
            ->orderByRaw("FIELD(status, 'absent', 'sick', 'annual')") // Order by absent, sick, then annual
            ->latest()
            ->get();
    }

    public function showAbsentEmployeeDetails($employeeId)
    {
        // Get the specific absent employee details
        $this->selectedAbsentEmployee = $this->absentEmployees->firstWhere('employee.id', $employeeId);
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
