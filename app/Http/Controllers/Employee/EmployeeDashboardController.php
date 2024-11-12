<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\EmployeeDetail;
use App\Notifications\ClockOutNotification;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user();
    
        // Check if the user is a Super Admin
        if ($employee->hasRole('Super Admin')) {
            $assignedProjects = collect();
            $assignedTasks = collect();
            $attendanceRecords = collect();
            $todayAttendance = null;
    
            return view('pages.employee.employeeDashboard', [
                'employee' => $employee,
                'assignedProjects' => $assignedProjects,
                'assignedTasks' => $assignedTasks,
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
    
        $assignedProjects = $employeeDetail->projects()->with('department')->get();
        $assignedTasks = $employeeDetail->tasks()->get();
        $attendanceRecords = $employeeDetail->attendances()->get();
    
        // Attempt to find today's attendance by iterating over the attendance records
        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();
    
        return view('pages.employee.employeeDashboard', [
            'employee' => $employee,
            'assignedProjects' => $assignedProjects,
            'assignedTasks' => $assignedTasks,
            'attendanceRecords' => $attendanceRecords,
            'todayAttendance' => $todayAttendance,
        ]);
    }
    
    
    public function clockIn(Request $request)
    {
        $employee = Auth::user();
    
        if (!$employee->hasRole('Employee')) {
            return redirect()->route('login')->with('error', 'Access denied. Only employees can clock in.');
        }
    
        // Fetch today's attendance record
        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();
    
        // Check if the employee has already clocked in and hasn't clocked out
        if ($todayAttendance && !$todayAttendance->clock_out) {
            return redirect()->route('employee.dashboard')->with('error', 'You have already clocked in today and haven’t clocked out yet.');
        }
    
        // If they haven’t clocked in today, or they have clocked out, create a new entry
        if (!$todayAttendance || ($todayAttendance && $todayAttendance->clock_out)) {
            Attendance::create([
                'employee_id' => $employee->id,
                'attendance_date' => Carbon::now(), // Storing full timestamp
                'clock_in' => Carbon::now(),
                'status' => 'Present', // Default status
            ]);
            

            return redirect()->route('employee.dashboard')->with('success', 'You have clocked in successfully.');
        }

        return redirect()->route('employee.dashboard')->with('error', 'Unexpected error while clocking in.');
    }
    
    public function clockOut()
    {
        $employee = Auth::user();
    
        if (!$employee->hasRole('Employee')) {
            return redirect()->route('login')->with('error', 'Access denied. Only employees can clock out.');
        }
    
        // Fetch today's attendance record
        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', Carbon::today())
            ->first();
    
        if ($attendance) {
            $clockInTime = $attendance->clock_in;
            $currentTime = Carbon::now();
    
            // Check if 12 hours have passed since clock in
            if ($clockInTime->diffInHours($currentTime) >= 12 && !$attendance->clock_out) {
                // Auto-clock out after 12 hours with 9 working hours as default
                $clockOutTime = $clockInTime->copy()->addHours(9); // Set clock out exactly 9 hours after clock in
                $attendance->update([
                    'clock_out' => $clockOutTime,
                    'total_hours' => 9, // Fixed to 9 hours as per the requirement
                ]);
    
                $employee->notify(new ClockOutNotification(9)); // Notify with 9 hours worked
    
                return redirect()->route('employee.dashboard')->with('success', 'You were automatically clocked out after 12 hours.');
            }
    
            // Manual clock-out if within valid range
            if (!$attendance->clock_out && $clockInTime->diffInHours($currentTime) >= 6) {
                // Manual clock out after 6+ hours
                $hoursWorked = round($clockInTime->diffInMinutes($currentTime) / 60, 2);
                $attendance->update([
                    'clock_out' => $currentTime,
                    'total_hours' => $hoursWorked,
                ]);
    
                $employee->notify(new ClockOutNotification($hoursWorked));
    
                return redirect()->route('employee.dashboard')->with('success', 'You have clocked out successfully.');
            }
        }
    
        return redirect()->route('employee.dashboard')->with('error', 'No valid attendance record found or you cannot clock out yet.');
    }
    
    
}
