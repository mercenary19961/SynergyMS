<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProjectManager;
use App\Models\EmployeeDetail; // Assuming EmployeeDetail is the model for employees
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();
    
        // Filter by department name
        if ($request->filled('department_name')) {
            $query->where('name', 'LIKE', '%' . $request->input('department_name') . '%');
        }
    
        // Filter by project manager
        if ($request->filled('project_manager')) {
            $query->whereHas('project_manager', function($q) use ($request) {
                $q->where('id', $request->input('project_manager'));
            });
        }
    
        // Filter by sector
        if ($request->filled('sector')) {
            $query->where('sector', $request->input('sector'));
        }
    
        $departments = $query->paginate(8);
        $projectManagers = ProjectManager::with('user')->get();
        $sectors = ['Projects', 'HR']; // Ensure these sectors are available in the filter dropdown
    
        return view('admin.departments.index', compact('departments', 'projectManagers', 'sectors'));
    }
    
    

    public function create()
    {
        $projectManagers = ProjectManager::with('user')->get();
        $employees = EmployeeDetail::all(); // Fetch all employees
        return view('admin.departments.create', compact('projectManagers', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'required|string|max:500',
            'project_manager' => 'nullable|exists:project_managers,id',
            'positions' => 'nullable|array',
            'employees' => 'nullable|string', // Handle employees as a comma-separated string
        ]);
    
        $department = Department::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'project_manager_id' => $validated['project_manager'] ?? null,
        ]);
    
        // Process employees and positions if provided
        if ($request->filled('positions')) {
            foreach ($request->positions as $position) {
                $department->positions()->create(['name' => $position]); // Changed 'title' to 'name'
            }
        }
    
        if ($request->filled('employees')) {
            $employeeIds = explode(',', rtrim($request->employees, ','));
            $department->employees()->sync($employeeIds);
        }
    
        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }
    
}
