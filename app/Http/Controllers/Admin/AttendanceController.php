<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeDetail;
use App\Models\ProjectManager;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['employee.user', 'employee.projectManager.user']);
        
        // Search by employee ID
        if ($request->has('employee_id') && $request->employee_id != '') {
            $query->where('employee_id', $request->employee_id);
        }
    
        // Search by employee name
        if ($request->has('employee_name') && $request->employee_name != '') {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }
    
        // Filter by attendance date
        if ($request->has('attendance_date') && $request->attendance_date != '') {
            $query->where('attendance_date', $request->attendance_date);
        }
    
        // Filter by status
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
        $employees = EmployeeDetail::with('user', 'projectManager.user')->get(); // Fetch employees with their user and project manager data
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
        $employees = EmployeeDetail::with('user', 'projectManager.user')->get();
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
