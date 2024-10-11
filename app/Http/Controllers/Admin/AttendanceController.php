<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeDetail;
use App\Models\ProjectManager;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['employee.user', 'employee.projectManager.user']);
        
        // Search by employee ID
        if ($request->has('employee_id') && $request->employee_id != '') {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('id', $request->employee_id);
            });
        }
    
        // Search by employee name
        if ($request->has('employee_name') && $request->employee_name != '') {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }
    
        if ($request->has('attendance_date') && $request->attendance_date != '') {
            $query->where('attendance_date', $request->attendance_date);
        }
    
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
    
        $attendances = $query->paginate(8);
    
        return view('admin.attendance.index', compact('attendances'));
    }
    

    public function show($id)
    {
        $attendance = Attendance::with(['employee.user', 'employee.projectManager.user'])->findOrFail($id);
    
        return view('admin.attendance.show', compact('attendance'));
    }
    

    public function create()
    {
        $employees = EmployeeDetail::with('user')->get(); // Fetch employees with their user data
        return view('admin.attendance.create', compact('employees'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_details,id',
            'attendance_date' => 'required|date',
            'clock_in' => 'required_if:status,present|nullable',
            'clock_out' => 'required_if:status,present|nullable',
            'total_hours' => 'nullable|numeric',
            'leave_hours' => 'nullable|numeric',
            'status' => 'required|string|max:255',
        ]);
    
        // Handle status-specific logic for time and hours
        if (in_array($validated['status'], ['absent', 'sick_leave', 'annual_leave'])) {
            // If absent, sick, or on leave, reset times and hours
            $validated['clock_in'] = '00:00';
            $validated['clock_out'] = '00:00';
            $validated['total_hours'] = 0;
            $validated['leave_hours'] = 0;
        } elseif ($validated['status'] === 'present') {
            // If the user provided total_hours directly and leave_hours is 0, use the input value
            if (isset($validated['leave_hours']) && $validated['leave_hours'] == 0) {
                // No leave hours, so just use the input total_hours
                $validated['total_hours'] = $request->input('total_hours');
            } else {
                // If clock in and clock out are provided, calculate the total hours
                $clockInTime = Carbon::createFromFormat('H:i', $validated['clock_in']);
                $clockOutTime = Carbon::createFromFormat('H:i', $validated['clock_out']);
    
                // Ensure clock_out is after clock_in to calculate total working hours
                if ($clockOutTime->greaterThan($clockInTime)) {
                    $totalHours = $clockOutTime->diffInHours($clockInTime);
                    // Subtract leave hours if applicable
                    $validated['total_hours'] = $totalHours - ($validated['leave_hours'] ?? 0);
                } else {
                    // If clock out is before clock in, set total hours to 0
                    $validated['total_hours'] = 0;
                }
            }
        }
    
        // Create the attendance record
        Attendance::create($validated);
    
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance created successfully.');
    }
    
    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        
        // Format clock_in and clock_out to 'H:i' before passing to the view
        $attendance->clock_in = Carbon::parse($attendance->clock_in)->format('H:i');
        $attendance->clock_out = Carbon::parse($attendance->clock_out)->format('H:i');
    
        $employees = EmployeeDetail::with('user')->get(); // Fetch employees with their user data
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }
    

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
    
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_details,id',
            'attendance_date' => 'required|date',
            'clock_in' => 'required_if:status,present|nullable',
            'clock_out' => 'required_if:status,present|nullable',
            'total_hours' => 'nullable|numeric',
            'leave_hours' => 'nullable|numeric',
            'status' => 'required|string|max:255',
        ]);
    
        // Handle status-specific logic for time and hours
        if (in_array($validated['status'], ['absent', 'sick_leave', 'annual_leave'])) {
            // If absent, sick, or on leave, reset times and hours
            $validated['clock_in'] = '00:00';
            $validated['clock_out'] = '00:00';
            $validated['total_hours'] = 0;
            $validated['leave_hours'] = 0;
        } elseif ($validated['status'] === 'present') {
            // If the user provided total_hours directly and leave_hours is 0, use the input value
            if (isset($validated['leave_hours']) && $validated['leave_hours'] == 0) {
                // No leave hours, so just use the input total_hours
                $validated['total_hours'] = $request->input('total_hours');
            } else {
                // If clock in and clock out are provided, calculate the total hours
                $clockInTime = Carbon::createFromFormat('H:i', $validated['clock_in']);
                $clockOutTime = Carbon::createFromFormat('H:i', $validated['clock_out']);
    
                // Ensure clock_out is after clock_in to calculate total working hours
                if ($clockOutTime->greaterThan($clockInTime)) {
                    $totalHours = $clockOutTime->diffInHours($clockInTime);
                    // Subtract leave hours if applicable
                    $validated['total_hours'] = $totalHours - ($validated['leave_hours'] ?? 0);
                } else {
                    // If clock out is before clock in, set total hours to 0
                    $validated['total_hours'] = 0;
                }
            }
        }
    
        // Update the attendance record with the validated data
        $attendance->update($validated);
    
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance updated successfully.');
    }
    

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
    
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance deleted successfully.');
    }
}
