<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectManager;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class ProjectManagerController extends Controller
{
    // Show all project managers
    public function index()
    {
        $projectManagers = ProjectManager::with('user', 'department')->get();
        return view('admin.project-managers.index', compact('projectManagers'));
    }

    // Show form to create a new project manager
    public function create()
    {
        $users = User::all(); // Get all users
        $departments = Department::all(); // Get all departments
        return view('admin.project-managers.create', compact('users', 'departments'));
    }

    // Store a new project manager
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'experience_years' => 'required|integer',
            'contact_number' => 'required|string|max:255',
        ]);

        ProjectManager::create($request->all());

        return redirect()->route('admin.project-managers.index')
                         ->with('success', 'Project Manager created successfully.');
    }

    // Show form to edit a project manager
    public function edit($id)
    {
        $projectManager = ProjectManager::findOrFail($id);
        $users = User::all(); // Get all users
        $departments = Department::all(); // Get all departments
        return view('admin.project-managers.edit', compact('projectManager', 'users', 'departments'));
    }

    // Update project manager
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'department_id' => 'required',
            'experience_years' => 'required|integer',
            'contact_number' => 'required|string|max:255',
        ]);

        $projectManager = ProjectManager::findOrFail($id);
        $projectManager->update($request->all());

        return redirect()->route('admin.project-managers.index')
                         ->with('success', 'Project Manager updated successfully.');
    }

    // Delete a project manager
    public function destroy($id)
    {
        $projectManager = ProjectManager::findOrFail($id);
        $projectManager->delete();

        return redirect()->route('admin.project-managers.index')
                         ->with('success', 'Project Manager deleted successfully.');
    }
}
