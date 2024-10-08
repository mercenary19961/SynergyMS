<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDetail;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|integer',
            'employee_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $query = EmployeeDetail::with('user');

        if ($request->filled('employee_id')) {
            $query->where('id', $request->employee_id);
        }

        if ($request->filled('employee_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }

        if ($request->filled('position')) {
            $query->where('position', 'like', '%' . $request->position . '%');
        }

        $positions = Cache::remember('employee_positions', 60, function () {
            return EmployeeDetail::select('position')->distinct()->pluck('position');
        });

        $employees = $query->paginate(12)->appends($request->except('page'));

        return view('admin.employees.index', compact('employees', 'positions'));
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
                        ->take(6)
                        ->get();
    
        return view('admin.employees.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string|in:male,female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|regex:/^\+[0-9]+$/',
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employee_images', 'public');
        }
    
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt('defaultpassword'),
            'gender' => $request->input('gender'),
        ]);
    
        $user->assignRole('Employee');
    
        EmployeeDetail::create([
            'user_id' => $user->id,
            'position' => $request->input('position'),
            'salary' => $request->input('salary'),
            'date_of_joining' => $request->input('date_of_joining'),
            'address' => $request->input('address'),
            'nationality' => $request->input('nationality'),
            'age' => $request->input('age'),
            'date_of_birth' => $request->input('date_of_birth'),
            'department_id' => $request->input('department_id'),
            'image' => $imagePath,
            'phone' => $request->input('phone'),
        ]);
    
        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
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
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id, // Allow existing email for the user being updated
            'gender' => 'required|string|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'phone' => 'required|string|regex:/^\+[0-9]+$/',
            'gender' => 'required|string|in:Male,Female,male,female',
        ]);
    
        // Update the User model
        $employee->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
        ]);
    
        // Update the EmployeeDetail model
        $employee->update([
            'position' => $request->input('position'),
            'salary' => $request->input('salary'),
            'date_of_joining' => $request->input('date_of_joining'),
            'address' => $request->input('address'),
            'nationality' => $request->input('nationality'),
            'age' => $request->input('age'),
            'date_of_birth' => $request->input('date_of_birth'),
            'department_id' => $request->input('department_id'),
            'phone' => $request->input('phone'),
        ]);
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employee_images', 'public');
            $employee->update(['image' => $imagePath]);
        }
    
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }
    
    public function destroy(EmployeeDetail $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
