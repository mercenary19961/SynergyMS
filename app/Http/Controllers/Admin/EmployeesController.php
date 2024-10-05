<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        // Eager load user and department relationships
        $employees = EmployeeDetail::with('user', 'department')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        // Validate and store new employee
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

        EmployeeDetail::create($request->all());

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(EmployeeDetail $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

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

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(EmployeeDetail $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
