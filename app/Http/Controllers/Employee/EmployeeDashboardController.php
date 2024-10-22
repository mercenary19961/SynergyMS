<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Project;
use App\Models\EmployeeDetail;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user();

        // Check if the user is a Super Admin
        if ($employee->hasRole('Super Admin')) {
            $assignedProjects = collect();
            $attendanceRecords = collect();
            $todayAttendance = null;

            return view('pages.employee.employeeDashboard', [
                'employee' => $employee,
                'assignedProjects' => $assignedProjects,
                'attendanceRecords' => $attendanceRecords,
                'todayAttendance' => $todayAttendance,
            ]);
        }

        // Check if the user has the 'Employee' role
        if (!$employee->hasRole('Employee')) {
            return redirect()->route('login')->with('error', 'Access denied. Only employees can access the dashboard.');
        }

        // Fetch the EmployeeDetail model
        $employeeDetail = EmployeeDetail::where('user_id', $employee->id)->first();
        if (!$employeeDetail) {
            return redirect()->route('login')->with('error', 'Employee details not found.');
        }

        $assignedProjects = $employeeDetail->projects()->get();
        $attendanceRecords = $employeeDetail->attendances()->get();
        $todayAttendance = $attendanceRecords->where('attendance_date', Carbon::today())->first();

        return view('pages.employee.employeeDashboard', [
            'employee' => $employee,
            'assignedProjects' => $assignedProjects,
            'attendanceRecords' => $attendanceRecords,
            'todayAttendance' => $todayAttendance,
        ]);
    }

    public function clockIn()
    {
        $employee = Auth::user();

        // Ensure that only employees can clock in
        if (!$employee->hasRole('Employee')) {
            return redirect()->route('login')->with('error', 'Access denied. Only employees can clock in.');
        }

        // Check if the employee has already clocked in today
        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();

        if ($todayAttendance) {
            return redirect()->route('employee.dashboard')->with('error', 'You have already clocked in today.');
        }

        // Clock in the employee
        Attendance::create([
            'employee_id' => $employee->id,
            'attendance_date' => Carbon::now(),
            'clock_in' => Carbon::now(),
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'You have clocked in successfully.');
    }

    public function clockOut()
    {
        $employee = Auth::user();

        // Ensure that only employees can clock out
        if (!$employee->hasRole('Employee')) {
            return redirect()->route('login')->with('error', 'Access denied. Only employees can clock out.');
        }

        // Fetch today's attendance record and clock out
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();

        if ($attendance && Carbon::now()->diffInHours($attendance->clock_in) >= 6) {
            $attendance->update([
                'clock_out' => Carbon::now(),
                'hours_worked' => Carbon::now()->diffInHours($attendance->clock_in),
            ]);

            return redirect()->route('employee.dashboard')->with('success', 'You have clocked out successfully.');
        } else {
            return redirect()->route('employee.dashboard')->with('error', 'You can only clock out after 6 hours.');
        }
    }
}
