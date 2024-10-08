<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProjectManager; 
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    public function show($id)
    {
        $department = Department::with(['positions', 'employees', 'project_managers'])->findOrFail($id);
        return view('admin.departments.show', compact('department'));
    }

    public function create()
    {
        $projectManagers = ProjectManager::with('user')->get();
        return view('admin.departments.create', compact('projectManagers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'required|string|max:500',
            'positions' => 'required|string|max:255',
            'project_manager' => 'nullable|exists:project_managers,id',
        ], [
            'name.required' => 'The department name is required.',
            'name.unique' => 'A department with this name already exists.',
            'description.required' => 'The description is required.',
            'positions.required' => 'The positions are required.',
            'project_manager.exists' => 'The selected project manager is invalid.',
        ]);
    
        // If validation passes, create the department
        Department::create($validated);
    
        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }
    

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($id);
        $department->update($validated);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
