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
    /**
     * Display a listing of the employees with search and pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Validate search inputs (optional but recommended)
        $request->validate([
            'employee_id' => 'nullable|integer',
            'employee_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        // Initialize the query with eager loading of 'user' relationship
        $query = EmployeeDetail::with('user');

        // Apply filtering based on the request inputs
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

        // Fetch distinct positions for the dropdown with caching
        $positions = Cache::remember('employee_positions', 60, function () {
            return EmployeeDetail::select('position')->distinct()->pluck('position');
        });

        // Paginate the results (12 per page) and preserve query string parameters
        $employees = $query->paginate(12)->appends($request->except('page'));

        // Pass employees and positions to the view
        return view('admin.employees.index', compact('employees', 'positions'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch users with role_id 5 (Employee role)
        $users = User::whereHas('roles', function ($query) {
            $query->where('id', 5); // Role id 5 for Employee
        })->get();
    
        // Fetch only the first six departments with their related positions
        $departments = Department::with('positions')
                        ->take(6) // Limit to first six departments
                        ->get();
    
        return view('admin.employees.create', compact('users', 'departments'));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|string|in:male,female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'department_id' => 'required|exists:departments,id',
        ]);
    
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees', 'public'); // Store image in 'public/employees' directory
        }
    
        // Create a new User
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt('defaultpassword'), // Set a default password or implement password input
            'gender' => $request->input('gender'),
            'image' => $imagePath, // Store the image path
            'role_id' => 3, // Set a default role ID, or allow dynamic selection if necessary
        ]);
    
        // Create a new EmployeeDetail
        EmployeeDetail::create([
            'user_id' => $user->id, // Link employee detail to the created user
            'position' => $request->input('position'),
            'salary' => $request->input('salary'),
            'date_of_joining' => $request->input('date_of_joining'),
            'address' => $request->input('address'),
            'nationality' => $request->input('nationality'),
            'age' => $request->input('age'),
            'date_of_birth' => $request->input('date_of_birth'),
            'department_id' => $request->input('department_id'),
        ]);
    
        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }
    

    /**
     * Show the form for editing the specified employee.
     *
     * @param  \App\Models\EmployeeDetail  $employee
     * @return \Illuminate\View\View
     */
    public function edit(EmployeeDetail $employee)
    {
        // Fetch necessary data for the form, e.g., users and departments
        $users = User::all(); // Adjust as needed
        $departments = Department::all(); // Adjust as needed

        return view('admin.employees.edit', compact('employee', 'users', 'departments'));
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeDetail  $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, EmployeeDetail $employee)
    {
        // Validate and update employee
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'position' => 'required|string',
            'salary' => 'required|numeric',
            'date_of_joining' => 'required|date',
            'address' => 'required|string',
            'nationality' => 'required|string',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'department_id' => 'required|exists:departments,id',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param  \App\Models\EmployeeDetail  $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(EmployeeDetail $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
