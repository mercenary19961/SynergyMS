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
            'department' => 'nullable|string|max:255',
        ]);
    
        $query = EmployeeDetail::with('user', 'department');
    
        if ($request->filled('employee_id')) {
            $query->where('id', $request->employee_id);
        }
    
        if ($request->filled('employee_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee_name . '%');
            });
        }
    
        if ($request->filled('department')) {
            $query->whereHas('department', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->department . '%');
            });
        }
    
        // Fetch first 6 departments based on ID
        $departments = Department::orderBy('id', 'asc')->take(6)->pluck('name', 'id');
    
        $employees = $query->paginate(8)->appends($request->except('page'));
    
        return view('admin.employees.index', compact('employees', 'departments'));
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
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }
    
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt('defaultpassword'),
            'gender' => $request->input('gender'),
            'image' => $imagePath, // Save the image path in the users table
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
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
        ]);
    
        $employee->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
            $employee->user->update(['image' => $imagePath]);
        }
    
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
    
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }
    
    
    public function destroy(EmployeeDetail $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
