<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Notifications\ClockOutNotification;

class ClockOutButton extends Component
{
    public $hoursWorked;
    public $autoClockOut = false;

    public function mount()
    {
        $this->checkClockOut();
    }

    public function checkClockOut()
    {
        $employee = Auth::user();

        // Fetch today's attendance record
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();

        if ($attendance && !$attendance->clock_out) {
            $clockInTime = $attendance->clock_in;
            $currentTime = Carbon::now();

            // Check if 12 hours have passed since clock-in
            if ($clockInTime->diffInHours($currentTime) >= 12) {
                // Auto clock-out after 12 hours, setting 9 hours as total working time
                $clockOutTime = $clockInTime->copy()->addHours(9);
                $attendance->update([
                    'clock_out' => $clockOutTime,
                    'total_hours' => 9,
                ]);

                $employee->notify(new ClockOutNotification(9));
                $this->autoClockOut = true;
                $this->hoursWorked = 9;
            } else {
                // Calculate time worked so far
                $this->hoursWorked = round($clockInTime->diffInMinutes($currentTime) / 60, 2);
            }
        }
    }

    public function render()
    {
        return view('livewire.clock-out-button');
    }
}
