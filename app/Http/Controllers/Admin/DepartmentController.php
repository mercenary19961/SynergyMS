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
    
    public function show($id)
    {
        // Find the department with its positions, employees, and project manager
        $department = Department::with(['positions', 'employees.user', 'project_manager.user'])->findOrFail($id);

        // Return the department details view with the department data
        return view('admin.departments.show', compact('department'));
    }
    public function create()
    {
        $projectManagers = ProjectManager::with('user')->get();
        $employees = EmployeeDetail::all(); // Fetch all employees
        $sectors = ['Projects', 'HR']; // Add sectors for the dropdown
        return view('admin.departments.create', compact('projectManagers', 'employees', 'sectors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'required|string|max:500',
            'sector' => 'required|string', // Validate sector input
            'project_manager' => 'nullable|exists:project_managers,id',
            'positions' => 'nullable|array',
            'employees' => 'nullable|string', // Handle employees as a comma-separated string
        ]);
    
        $department = Department::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'sector' => $validated['sector'], // Store sector
            'project_manager_id' => $validated['project_manager'] ?? null,
        ]);
    
        // Process employees and positions if provided
        if ($request->filled('positions')) {
            foreach ($request->positions as $position) {
                $department->positions()->create(['name' => $position]); // Create positions
            }
        }
    
        if ($request->filled('employees')) {
            $employeeIds = explode(',', rtrim($request->employees, ','));
            $department->employees()->sync($employeeIds);
        }
    
        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $projectManagers = ProjectManager::with('user')->get();
        $employees = EmployeeDetail::all();
        $sectors = ['Projects', 'HR'];
        
        return view('admin.departments.edit', compact('department', 'projectManagers', 'employees', 'sectors'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'required|string|max:500',
            'sector' => 'required|string',
            'project_manager' => 'nullable|exists:project_managers,id',
            'positions' => 'nullable|array',
        ]);
    
        // Update department information
        $department->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'sector' => $validated['sector'],
        ]);
    
        // Update the project manager
        if ($request->filled('project_manager')) {
            // If a new project manager is assigned, update their department_id
            ProjectManager::where('id', $validated['project_manager'])->update(['department_id' => $department->id]);
    
            // If the department had a previous project manager, reset their department_id
            ProjectManager::where('department_id', $department->id)
                ->where('id', '!=', $validated['project_manager'])
                ->update(['department_id' => null]);
        }
    
        // Process positions if provided
        $department->positions()->delete(); // Remove old positions
        if ($request->filled('positions')) {
            foreach ($request->positions as $position) {
                $department->positions()->create(['name' => $position]); // Add new positions
            }
        }
    
        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }
    
    public function destroy(Department $department)
    {
        $department->positions()->delete();
        $department->employees()->update(['department_id' => null]);
        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
