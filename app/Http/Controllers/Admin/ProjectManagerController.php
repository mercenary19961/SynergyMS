<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectManager;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProjectManagerController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
    
        // Initialize the query
        $query = ProjectManager::with('user', 'department');
    
        // Apply filters if provided
        if ($request->filled('name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
    
        if ($request->filled('department')) {
            $query->whereHas('department', function($q) use ($request) {
                $q->where('name', $request->department);
            });
        }
    
        if ($request->filled('experience_years')) {
            $query->where('experience_years', '>=', $request->input('experience_years'));
        }
    
        // Apply sorting and pagination
        $projectManagers = $query->orderBy($sort, $direction)->paginate(10);
        $departments = Department::where('sector', 'Projects')->get();
    
        return view('admin.project-managers.index', compact('projectManagers', 'departments'));
    }
    

    public function show($id)
    {
        $projectManager = ProjectManager::with([
            'user', 
            'department.employees.user',
            'projects'
        ])->findOrFail($id);
    
        return view('admin.project-managers.show', compact('projectManager'));
    }
    
    

    public function create()
    {
        return view('admin.project-managers.create');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users,email',
            'user_password' => 'required|string|min:8|confirmed',
            'gender' => 'required|string|in:Male,Female',
            'image' => 'nullable|image|max:2048',
            'department_id' => 'required|exists:departments,id',
            'experience_years' => 'required|integer',
            'contact_number' => 'required|string|max:255',
        ]);

        // Handle profile image upload if provided
        $profileImagePath = null;
        if ($request->hasFile('image')) {
            $profileImagePath = $request->file('image')->store('project_managers', 'public');
        }

        // Create the User
        $user = User::create([
            'name' => $request->input('user_name'),
            'email' => $request->input('user_email'),
            'password' => Hash::make($request->input('user_password')),
            'gender' => $request->input('gender'),
            'profile_image' => $profileImagePath,
        ]);

        // Assign 'Project Manager' role using Spatie
        $user->assignRole('Project Manager');

        // Create the Project Manager
        ProjectManager::create([
            'user_id' => $user->id,
            'department_id' => $request->input('department_id'),
            'experience_years' => $request->input('experience_years'),
            'contact_number' => $request->input('contact_number'),
        ]);

        return redirect()->route('admin.project-managers.index')->with('success', 'Project Manager and User created successfully.');
    }

    public function edit($id)
    {
        $projectManager = ProjectManager::with('user', 'department')->findOrFail($id);
        return view('admin.project-managers.edit', compact('projectManager'));
    }
    
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255',
            'user_password' => 'nullable|string|min:8|confirmed',
            'experience_years' => 'required|integer',
            'contact_number' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'gender' => 'required|string',
        ]);
    
        $projectManager = ProjectManager::findOrFail($id);
        $user = $projectManager->user;
    
        // Update the user fields
        $user->name = $request->user_name;
        $user->email = $request->user_email;
        $user->gender = $request->gender;
        
        if ($request->filled('user_password')) {
            $user->password = bcrypt($request->user_password);
        }
        
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('project_managers', 'public');
        }
        
        $user->save();
    
        // Update the project manager fields
        $projectManager->update($request->only('experience_years', 'contact_number', 'department_id'));
    
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
