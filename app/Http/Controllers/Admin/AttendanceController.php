<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeDetail;
use App\Models\ProjectManager;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['employee.user', 'projectManager.user'])->get();
        return view('admin.attendance.index', compact('attendances'));
    }

    public function create()
    {
        $employees = EmployeeDetail::with('user')->get(); // Fetch employees with their user data
        $projectManagers = ProjectManager::with('user')->get(); // Fetch project managers with their user data

        return view('admin.attendance.create', compact('employees', 'projectManagers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_details,id',
            'project_manager_id' => 'required|exists:project_managers,id',
            'attendance_date' => 'required|date',
            'clock_in' => 'required',
            'clock_out' => 'nullable',
            'total_hours' => 'nullable|numeric',
            'leave_hours' => 'nullable|numeric',
            'status' => 'required|string|max:255',
        ]);

        Attendance::create($validated);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance created successfully.');
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);
        $employees = EmployeeDetail::with('user')->get();
        $projectManagers = ProjectManager::with('user')->get();

        return view('admin.attendance.edit', compact('attendance', 'employees', 'projectManagers'));
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:employee_details,id',
            'project_manager_id' => 'required|exists:project_managers,id',
            'attendance_date' => 'required|date',
            'clock_in' => 'required',
            'clock_out' => 'nullable',
            'total_hours' => 'nullable|numeric',
            'leave_hours' => 'nullable|numeric',
            'status' => 'required|string|max:255',
        ]);

        $attendance->update($validated);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance updated successfully.');
    }
}
