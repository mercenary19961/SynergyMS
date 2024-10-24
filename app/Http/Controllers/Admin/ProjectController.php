<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Department;
use App\Models\ProjectManager;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Query for filtering projects
        $query = Project::query();
    
        // Filtering by Project Name
        if ($request->filled('project_manager')) {
            $query->whereHas('projectManager.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('project_manager') . '%');
            });
        }
    
        // Filtering by Department
        if ($request->has('department') && $request->department != '') {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('name', $request->department);
            });
        }
    
        // Filtering by Project Manager
        if ($request->has('project_manager_name') && $request->project_manager_name != '') {
            $query->whereHas('projectManager.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->project_manager_name . '%');
            });
        }
    
        // Filtering by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
    
        // Get the filtered projects with pagination
        $projects = $query->paginate(8);
    
        // Retrieve project managers and departments for the dropdowns
        $projectManagers = ProjectManager::with('user')->get();
        $departments = Department::where('sector', 'Projects')->get();
    
        return view('admin.projects.index', compact('projects', 'departments', 'projectManagers'));
    }
    
    // Show the form for creating a new project
    public function create()
    {
        $departments = Department::with('project_manager')->get();
        $clients = Client::all();
    
        return view('admin.projects.create', compact('departments', 'clients'));
    }
    
    // Store a newly created project in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'project_manager_id' => 'required|exists:project_managers,id',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        Project::create($request->all());

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project created successfully');
    }

    // Show a single project
    public function show(Project $project)
    {
        // Get related department and client details
        $project->load('department', 'client', 'projectManager.user');
        
        return view('admin.projects.show', compact('project'));
    }


    // Show the form for editing a project
    public function edit(Project $project)
    {
        // Get all departments with their project managers
        $departments = Department::with('project_manager')->get();

        // Get all clients
        $clients = Client::all();

        // Pass project data, departments, and clients to the view
        return view('admin.projects.edit', compact('project', 'departments', 'clients'));
    }

    // Update the specified project in the database
    public function update(Request $request, Project $project)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'project_manager_id' => 'required|exists:project_managers,id',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        // Update the project with the validated data
        $project->update($request->all());

        // Redirect back to the projects index with a success message
        return redirect()->route('admin.projects.index')
                        ->with('success', 'Project updated successfully');
    }


    // Delete a project
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Project deleted successfully');
    }
}
