<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDetail;
use App\Models\User;
use App\Models\ProjectManager;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'employee_id' => 'nullable|integer',
            'employee_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'project_manager' => 'nullable|integer',
        ]);
    
        // Query employees with user, department, and position relationships
        $query = EmployeeDetail::with(['user', 'department', 'position']);
    
        // Filter by employee ID if provided
        if ($request->filled('employee_id')) {
            $query->where('id', $request->employee_id);
        }
    
        // Filter by employee name if provided
        if ($request->filled('employee_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }
    
        // Filter by department if provided
        if ($request->filled('department')) {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->department . '%');
            });
        }
    
        // Filter by project manager if provided
        if ($request->filled('project_manager')) {
            // Fetch the department associated with the given project manager
            $projectManager = ProjectManager::find($request->project_manager);
            if ($projectManager && $projectManager->department) {
                $query->where('department_id', $projectManager->department->id);
            }
        }
    
        // Get the list of departments under the 'Projects' sector for the dropdown
        $departments = Department::where('sector', 'Projects')->orderBy('id', 'desc')->get(['id', 'name']);
    
        // Get the list of project managers
        $projectManagers = ProjectManager::with('user')->get();
    
        // Paginate the results and pass along query params to persist the search
        $employees = $query->paginate(8)->appends($request->except('page'));
    
        // Return the view with the filtered employee list and departments for the search form
        return view('admin.employees.index', compact('employees', 'departments', 'projectManagers'));
    }
    
    public function show(EmployeeDetail $employee)
    {
        $employee->load('user', 'department', 'attendances', 'tickets');
    
        return view('admin.employees.show', compact('employee'));
    }

    public function create()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('id', 5);
        })->get();
    
        $departments = Department::with('positions')
        ->where('sector', 'projects') 
        ->get();
    
        return view('admin.employees.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|regex:/^\+[0-9]+$/',
        ]);
    
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employee_images', 'public');
            }

            DB::transaction(function () use ($request, $imagePath) {
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt('defaultpassword'),
                    'gender' => $request->input('gender'),
                    'image' => $imagePath,
                ]);

                $user->assignRole('Employee');

                EmployeeDetail::create([
                    'user_id' => $user->id,
                    'position_id' => $request->input('position_id'),
                    'salary' => $request->input('salary'),
                    'date_of_joining' => $request->input('date_of_joining'),
                    'address' => $request->input('address'),
                    'nationality' => $request->input('nationality'),
                    'age' => $request->input('age'),
                    'date_of_birth' => $request->input('date_of_birth'),
                    'department_id' => $request->input('department_id'),
                    'phone' => $request->input('phone'),
                ]);
            });

            Log::info('Employee created successfully', ['email' => $request->input('email')]);

            return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create employee', [
                'email' => $request->input('email'),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withInput()->with('error', 'Failed to create employee. Please try again.');
        }
    }
    

    public function edit(EmployeeDetail $employee)
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('id', 5);
        })->get();
    
        $departments = Department::with('positions')
                        ->take(6)
                        ->get();

        return view('admin.employees.edit', compact('employee', 'users', 'departments'));
    }
    public function update(Request $request, EmployeeDetail $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'gender' => 'required|string|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|regex:/^\+[0-9]+$/',
        ]);
    
        $employee->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employee_images', 'public');
            $employee->user->update(['image' => $imagePath]);
        }
    
        $employee->update([
            'position_id' => $request->input('position_id'),
            'salary' => $request->input('salary'),
            'date_of_joining' => $request->input('date_of_joining'),
            'address' => $request->input('address'),
            'nationality' => $request->input('nationality'),
            'age' => $request->input('age'),
            'date_of_birth' => $request->input('date_of_birth'),
            'department_id' => $request->input('department_id'),
            'phone' => $request->input('phone'),
        ]);
    
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }
    
    
    public function destroy(EmployeeDetail $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
